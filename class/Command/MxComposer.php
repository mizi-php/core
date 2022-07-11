<?php

namespace Command;

use Mizi\Dir;
use Mizi\Terminal;

abstract class MxComposer extends Terminal
{
    protected static function execute()
    {
        $composer = json('composer');

        $composer['autoload'] = $composer['autoload'] ?? [];
        $composer['autoload']['psr-4'] = $composer['autoload']['psr-4'] ?? [];
        $composer['autoload']['psr-4'][''] = 'class/';

        $autoImport = './source/helper';

        $files = [];

        foreach ($composer['autoload']['files'] ?? [] as $file)
            if (substr($file, 0, strlen($autoImport)) != $autoImport)
                $files[] = $file;

        $files = [...$files, ...self::seek_for_file($autoImport)];

        $composer['autoload']['files'] = $files;

        json('composer', $composer, false);

        Terminal::show('Arquivo [composer.json] atualizado');

        self::update();
    }

    protected static function update()
    {
        Terminal::show('------------------------------------------------------------');
        echo shell_exec("composer update");
        Terminal::show('------------------------------------------------------------');
    }

    protected static function seek_for_file($ref)
    {
        $return = [];

        foreach (Dir::seek_for_dir($ref) as $dir)
            foreach (self::seek_for_file("$ref/$dir") as $file)
                $return[] = path($file);

        foreach (Dir::seek_for_file($ref) as $file)
            $return[] = path("$ref/$file");

        return $return;
    }
}