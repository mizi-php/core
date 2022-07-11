<?php

namespace Command;

use Mizi\Dir;
use Mizi\Terminal;

abstract class MxStructure extends Terminal
{
    protected static $structure = [
        './class',
        './class/Command',
        './library',
        './source',
        './source/helper',
        './source/helper/constant',
        './source/helper/function',
        './source/helper/script',
    ];

    protected static function execute($mode = true)
    {
        $mode = match ($mode) {
            'FALSE', 'false', 'cls', 'clear', 'clean' => false,
            default => boolval($mode)
        };

        $mode ? self::create() : self::clear();
    }

    protected static function create()
    {
        foreach (self::$structure as $dir) {
            if (!Dir::check($dir)) {
                Dir::create($dir);
                Terminal::show('Diretório [#] [#green]criado', [$dir]);
            }
        }
        Terminal::show('Estrutura de pastas criada');
    }

    protected static function clear()
    {
        foreach (array_reverse(self::$structure) as $dir) {
            if (Dir::check($dir)) {
                if (empty(Dir::seek_for_all($dir))) {
                    Dir::remove($dir);
                    Terminal::show('Diretório [#] [#yellow]removido', [$dir]);
                }
            }
        }
        Terminal::show('Estrutura de pastas limpa');
    }
}