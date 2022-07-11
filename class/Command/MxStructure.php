<?php

namespace Command;

use Mizi\Dir;
use Mizi\MxCmd;

class MxStructure extends MxCmd
{
    protected $structure = [
        './class',
        './library',
        './source',
        './source/helper',
        './source/helper/constant',
        './source/helper/function',
        './source/helper/script',
    ];

    protected function execute($mode = true)
    {
        $mode = match ($mode) {
            'FALSE', 'false', 'cls', 'clear', 'clean' => false,
            default => boolval($mode)
        };

        $mode ? self::create() : self::clear();
    }

    protected function create()
    {
        foreach ($this->structure as $dir) {
            if (!Dir::check($dir)) {
                Dir::create($dir);
                MxCmd::show('Diretório [#] [#green]criado', [$dir]);
            }
        }
        MxCmd::show('Estrutura de pastas criada');
    }

    protected function clear()
    {
        foreach (array_reverse($this->structure) as $dir) {
            if (Dir::check($dir)) {
                if (empty(Dir::seek_for_all($dir))) {
                    Dir::remove($dir);
                    MxCmd::show('Diretório [#] [#yellow]removido', [$dir]);
                }
            }
        }
        MxCmd::show('Estrutura de pastas limpa');
    }
}