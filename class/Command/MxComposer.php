<?php

namespace Command;

use Mizi\Dir;
use Mizi\MxCmd;

class MxComposer extends MxCmd
{
    protected function execute()
    {
        $composer = json('composer');

        $composer['autoload'] = $composer['autoload'] ?? [];
        $composer['autoload']['psr-4'] = $composer['autoload']['psr-4'] ?? [];
        $composer['autoload']['psr-4'][''] = 'class/';

        $autoImport = './source/helper';

        $files = [];

        foreach ($composer['autoload']['files'] ?? [] as $file) {
            if (substr($file, 0, strlen($autoImport)) != $autoImport) {
                $files[] = $file;
            }
        }

        $files = [...$files, ...$this->seek_for_file($autoImport)];

        $composer['autoload']['files'] = $files;

        json('composer', $composer, false);

        MxCmd::show('Arquivo [composer.json] atualizado');

        $this->update();
    }

    protected function update()
    {
        MxCmd::show('------------------------------------------------------------');
        echo shell_exec("composer update");
        MxCmd::show('------------------------------------------------------------');
    }

    protected function seek_for_file($ref)
    {
        $return = [];
        foreach (Dir::seek_for_dir($ref) as $dir) {
            foreach ($this->seek_for_file("$ref/$dir") as $file) {
                $return[] = path($file);
            }
        }
        foreach (Dir::seek_for_file($ref) as $file) {
            $return[] = path("$ref/$file");
        }
        return $return;
    }
}