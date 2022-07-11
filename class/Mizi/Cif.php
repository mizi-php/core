<?php

namespace Mizi;

use Mizi\Cif\InstanceCif;

abstract class Cif
{
    /** Instancia de Cif */
    protected static $instanceCif;

    /** Retorna a instancia de CIF da classe estatica */
    protected static function instance(): InstanceCif
    {
        self::$instanceCif = self::$instanceCif ??  new InstanceCif();
        return self::$instanceCif;
    }

    /** Retorna a cifra de uma string */
    static function on(string $string, string $key = null): string
    {
        return self::instance()->on($string, $key);
    }

    /** Retorna a string de uma cifra */
    static function off(string $string): string
    {
        return self::instance()->off($string);
    }

    /** Verifica se uma string atende os requisitos para ser uma cifra */
    static function check(string $string): bool
    {
        return is_string($string) ? self::instance()->check($string) : false;
    }

    /** Verifica se duas strings decifradas são iguais */
    static function compare(string $string, string $compare): bool
    {
        return self::instance()->compare($string, $compare);
    }
}