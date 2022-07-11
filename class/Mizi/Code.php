<?php

namespace Mizi;

use Mizi\Code\InstanceCode;

abstract class Code
{
    /** Instancia de Code */
    protected static $instanceCode;

    /** Retorna a instancia de Code da classe estatica */
    protected static function instance(): InstanceCode
    {
        self::$instanceCode = self::$instanceCode ?? new InstanceCode();
        return self::$instanceCode;
    }

    /** Retorna o codigo de uma string */
    static function on(string $string): string
    {
        return self::instance()->on($string);
    }

    /** Retonra o MD5 usado para gerar uma string codificada */
    static function off(string $string): string
    {
        return self::instance()->off($string);
    }

    /** Verifica se uma string é uma string codificada */
    static function check(mixed $string): bool
    {
        return is_string($string) ? self::instance()->check($string) : false;
    }

    /** Verifica se duas strings tem a mesma string codificada */
    static function compare(string $string, string $compare): bool
    {
        return self::instance()->compare($string, $compare);
    }
}