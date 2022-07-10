<?php

if (!function_exists('path')) {

    /** Formata um caminho de diretório aplicando as referencias mapeadas */
    function path(): string
    {
        $path = str_replace('\\', '/', implode('/', func_get_args()));
        $path = str_trim($path, '/');
        $path = str_replace_all('//', '/', $path);
        return $path;
    }
}