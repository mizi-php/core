<?php

namespace Mizi;

abstract class Env
{
    /** Carrega variaveis de ambiente de um arquivo para o sistema */
    static function loadFile(string $filePath): bool
    {
        if (File::check($filePath)) {
            $lines = file(path($filePath), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') !== 0) {
                    list($name, $value) = explode('=', $line, 2);
                    self::set($name, $value);
                }
            }
            return true;
        }
        return false;
    }

    /** Define o valor de uma variavel de ambiente */
    static function set(string $name, mixed $value): void
    {
        $name = trim($name);
        $value = trim($value, " \"'");

        $value = match ($value) {
            'true', 'TRUE' => true,
            'false', 'FALSE' => false,
            'null', 'NULL' => null,
            default => $value
        };

        putenv(sprintf('%s=%s', $name, $value));

        $_ENV[$name] = $_ENV[$name] ?? $value;
        $_SERVER[$name] = $_SERVER[$name] ?? $value;
    }

    /** Recupera o valor de uma variavel de ambiente */
    static function get(string $name): mixed
    {
        return $_ENV[$name] ?? null;
    }

    /** Define variaveis de ambiente padrão caso não tenha sido declarada */
    static function default(string $name, mixed $value): void
    {
        if (is_null(self::get($name)) && !is_null($value)) {
            self::set($name, $value);
        }
    }
}