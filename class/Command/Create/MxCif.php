<?php

namespace Command\Create;

use Exception;
use Mizi\Cif\InstanceCif;
use Mizi\File;
use Mizi\Terminal;

abstract class MxCif extends Terminal
{
    protected static function execute($name = null)
    {
        if (!$name)
            throw new Exception('Informe um nome para o certificado');

        $fileName = "./source/certificate/$name.crt";

        if (File::check($fileName))
            throw new Exception("Certificado [$name] já existe");

        $allowChar = InstanceCif::BASE;

        $content = [];
        while (count($content) < 63) {
            $charKey = str_shuffle($allowChar);

            while ($charKey == $allowChar || in_array($charKey, $content))
                $charKey = str_shuffle($allowChar);

            $charKey = implode(' ', str_split($charKey, 2));
            $content[] = $charKey;
        }

        $content = implode(' ', $content);

        $content = str_split($content, 21);

        $content = array_map(fn ($value) => trim($value), $content);

        $content = implode("\n", $content);

        File::create($fileName, $content, true);

        Terminal::show('Certificado [[#].crt] criado com sucesso.', $name);
        Terminal::show('Adiciona [CIF_FILE=[#]] em suas variaveis de ambiente para utiliza-lo', $name);
    }
}