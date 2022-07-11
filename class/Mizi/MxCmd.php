<?php

namespace Mizi;

use Exception;

abstract class MxCmd
{
    protected function __construct()
    {
    }

    abstract protected function execute();

    /** Executa comandos no terminal */
    static final function run(...$commands)
    {
        $commands = array_filter($commands);

        if (empty($commands)) $commands = ['logo'];

        foreach ($commands as $command) {

            $command = trim($command);

            if ($command) {
                $parms = explode(' ', $command);

                $class = array_shift($parms);
                $class = explode('.', $class);
                $class = array_map(fn ($value) => ucfirst($value), $class);
                $class[] = "Mx" . array_pop($class);
                $class = implode('\\', $class);
                $class = "\\Command\\$class";

                if (!class_exists($class))
                    throw new Exception("Comando [$command] não encontrado");

                if (!is_extend($class, static::class))
                    throw new Exception("Comando [$command] não pode ser executado");

                if (!(new $class(...$parms))->execute(...$parms))
                    return false;
            }
        }

        return true;
    }

    /** Imprime uma linha no terminal */
    static final function show(string $line = '', string|array $prepare = []): void
    {
        if (IS_TERMINAL) echo prepare("$line\n", $prepare);
    }
}