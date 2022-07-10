<?php

use Mizi\File;
use Mizi\Import;

if (!function_exists('json')) {

    /** Retorna/Altera uma configuração JSON */
    function json(string $file, ?array $value = null, bool $merge = false): array
    {
        File::ensure_extension($file, 'json');

        $content = [];
        if (File::check($file)) {
            $content = Import::content($file);
            $content = is_json($content) ? json_decode($content, true) : [];
        }

        if (!is_null($value)) {
            $content = $merge ? [...$content, ...$value] : $value;
            $json    = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            File::create($file, $json, true);
        }

        return $content;
    }
}