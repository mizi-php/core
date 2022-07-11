<?php

namespace Mizi;

abstract class Import
{
    /** Retorna o conteúdo de um aquivo */
    static function content($filePath): ?string
    {
        $filePath = path($filePath);
        if (File::check($filePath)) {
            $content =  file_get_contents($filePath);
        }
        return $content ?? null;
    }

    /** Retorna o resultado (return) em um arquivo php  */
    static function return(string $filePath, array $params = [], bool $prepare = true): mixed
    {
        $filePath = path($filePath);
        File::ensure_extension($filePath, 'php');

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, $__PARAMS__) {
                foreach ($__PARAMS__ as $__VAR__ => $__VALUE__) {
                    if (!is_numeric($__VAR__)) {
                        $$__VAR__ = $__VALUE__;
                    }
                }
                ob_start();
                $__RETURN__ = require $__FILEPATH__;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);

            if ($prepare) {
                $return = is_string($return) ? prepare($return, $params) : $return;
            }
        }

        return $return ?? null;
    }

    /** Retorna o valor de uma variavel dentro de em um arquivo php  */
    static function var(string $filePath, string $varName, array $params = [], bool $prepare = true): mixed
    {
        $filePath = path($filePath);
        File::ensure_extension($filePath, 'php');

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, $__VARNAME__, $__PARAMS__) {
                foreach ($__PARAMS__ as $__VAR__ => $__VALUE__) {
                    if (!is_numeric($__VAR__)) {
                        $$__VAR__ = $__VALUE__;
                    }
                }
                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = $$__VARNAME__ ?? null;
                ob_end_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $varName, $params);

            if ($prepare) {
                $return = is_string($return) ? prepare($return, $params) : $return;
            }
        }

        return $return ?? null;
    }

    /** Retorna a saída de texto gerada por um arquivo */
    static function output(string $filePath, array $params = [], bool $prepare = true): string
    {
        $filePath = path($filePath);

        if (File::check($filePath)) {

            $return = function ($__FILEPATH__, $__PARAMS__) {
                foreach ($__PARAMS__ as $__VAR__ => $__VALUE__) {
                    if (!is_numeric($__VAR__)) {
                        $$__VAR__ = $__VALUE__;
                    }
                }
                ob_start();
                require $__FILEPATH__;
                $__RETURN__ = ob_get_clean();
                return $__RETURN__;
            };

            $return = $return($filePath, $params);

            if ($prepare) {
                $return = is_string($return) ? prepare($return, $params) : $return;
            }
        }

        return $return ?? '';
    }
}