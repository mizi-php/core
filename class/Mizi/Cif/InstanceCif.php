<?php

namespace Mizi\Cif;

use Mizi\File;
use Mizi\Import;
use Error;

class InstanceCif
{
    protected array $cif;
    protected array $ensure;
    protected string $currentKey;

    final const BASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    function __construct(?string $certificate = null)
    {
        $certificate = $certificate ?? env('CIF_FILE');

        if ($certificate) {
            $certificate = "./source/certificate/$certificate";
            File::ensure_extension($certificate, 'crt');
            $certificate = path($certificate);
        } else {
            $certificate = (dirname(__DIR__, 3) . '/source/certificate/base.crt');
        }

        if (!File::check($certificate))
            throw new Error("Impossivel localizar o arquivo de certificado [$certificate].");

        $content = Import::content($certificate);
        $content = str_replace([" ", "\t", "\n", "\r", "\0", "\x0B"], '', $content);
        $cif = str_split($content, 62);

        $this->ensure = str_split(array_pop($cif));
        $this->cif = $cif;
    }

    /** Retorna a cifra de uma string */
    function on(string $string, ?string $key = null): string
    {
        if (is_null($string) || $this->check($string))
            return $string;

        $key = $key ?? env('CIF_KEY');

        if ($key !== false) {

            $key = ($key !== null && $key !== true) ? $this->get_key_char(substr("$key", 0, 1)) : $this->get_key();

            $string = base64_encode($string);

            $string = str_replace('=', '', $string);

            $string = strrev($string);

            $string = $this->replace($string, self::BASE, $this->cif[$key]);

            $string = $this->get_char_key($key) . $string . $this->get_char_key($key, true);

            $string = str_replace('/', '-', $string);

            $string = "-$string-";
        }

        return $string;
    }

    /** Retorna a string de uma cifra */
    function off(string $string): string
    {
        if ($this->check($string)) {
            $key    = $this->get_key_char(substr($string, 1, 1));

            $string = substr($string, 2, -2);

            $string = str_replace('-', '/', $string);

            $string = $this->replace($string, $this->cif[$key], self::BASE);

            $string = base64_decode(strrev($string));
        }

        return $string;
    }

    /** Verifica se uma string atende os requisitos para ser uma cifra */
    function check(string $string): bool
    {
        if (substr($string, 0, 1) == '-')
            if (substr($string, -1) == '-') {
                $key = $this->get_key_char(substr($string, 1, 1));
                return substr($string, -2, 1) == $this->get_char_key($key, true);
            }

        return false;
    }

    /** Verifica se duas strings decifradas são iguais */
    function compare(string $string, string $compare): bool
    {
        return boolval($this->off($string) == $this->off($compare));
    }

    /** Realiza o replace interno de uma string */
    protected function replace(string $string, string $in, string $out): string
    {
        for ($i = 0; $i < strlen($string); $i++)
            if (strpos($in, $string[$i]) !== false)
                $string[$i] = $out[strpos($in, $string[$i])];

        return $string;
    }

    /** Retorna uma chave */
    protected function get_key(bool $random = true): string
    {
        if ($random) {
            return random_int(0, 61);
        } else {
            $this->currentKey = $this->currentKey ?? random_int(0, 61);
            return $this->currentKey;
        }
    }

    /** Retorna a chave de um caracter */
    protected function get_key_char(string $char): string
    {
        return array_flip($this->ensure)[$char] ?? 0;
    }

    /** Retorna o caracter de uma chave */
    protected function get_char_key(string $key, bool $inverse = false): string
    {
        $key = $inverse ? 61 - $key : $key;
        $key = $this->ensure[$key] ?? 0;
        return $key;
    }
}