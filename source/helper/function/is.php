<?php

if (!function_exists('is_class')) {

    /** Verifica se um objeto é ou extende uma classe */
    function is_class(mixed $object, object|string $class): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;
            $class = is_string($class) ? $class : $class::class;

            if (class_exists($object) && class_exists($class)) {
                return $object == $class || isset(class_parents($object)[$class]);
            }
        }

        return false;
    }
}

if (!function_exists('is_extend')) {

    /** Vrifica se um objeto extende uma classe */
    function is_extend(mixed $object, object|string $class): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;
            $class = is_string($class) ? $class : $class::class;

            if (class_exists($object) && class_exists($class)) {
                return isset(class_parents($object)[$class]);
            }
        }

        return false;
    }
}

if (!function_exists('is_implement')) {

    /** Vrifica se um objeto implementa uma interface */
    function is_implement(mixed $object, object|string $interface): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;

            if (class_exists($object) && interface_exists($interface)) {
                return isset(class_implements($object)[$interface]);
            }
        }

        return false;
    }
}

if (!function_exists('is_trait')) {

    /** Vrifica se um objeto utiliza uma trait */
    function is_trait(mixed $object, object|string|null $trait): bool
    {
        if (is_string($object) || is_object($object)) {
            $object = is_string($object) ? $object : $object::class;

            if (class_exists($object) && trait_exists($trait)) {
                if (isset(class_uses($object)[$trait])) {
                    return true;
                } else {
                    foreach (class_parents($object) as $parrent) {
                        if (isset(class_uses($parrent)[$trait])) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}

if (!function_exists('is_blank')) {

    /** Verifica se uma variavel é nula, vazia ou composta de espaços em branco */
    function is_blank(mixed $var): bool
    {
        if (is_string($var)) $var = trim($var);
        return is_null($var) || (empty($var) && !is_numeric($var) && !is_bool($var));
    }
}

if (!function_exists('is_md5')) {

    /** Verifica se uma string é um MD5 */
    function is_md5(mixed $string): bool
    {
        return is_string($string) ? boolval(preg_match('/^[a-fA-F0-9]{32}$/', $string)) : false;
    }
}

if (!function_exists('is_json')) {

    /** Verifica se uma string é um objeto JSON */
    function is_json(mixed $string): bool
    {
        try {
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        } catch (Error | Exception) {
            return false;
        }
    }
}