<?php

namespace Command\Create;

use Exception;
use Mizi\File;
use Mizi\Import;
use Mizi\MxCmd;

class MxCommand extends MxCmd
{
    protected function execute($commandName = null)
    {
        if (!$commandName)
            throw new Exception("Informe o nome do comando");

        $tmp = $commandName;
        $tmp = explode('.', $tmp);
        $tmp = array_map(fn ($value) => ucfirst($value), $tmp);

        $class = "Mx" . array_pop($tmp);

        $namespace = implode('\\', $tmp);
        $namespace = trim("Command\\$namespace", '\\');

        $filePath = "class/" . str_replace('\\', '/', $namespace) . "/$class.php";

        if (File::check($filePath))
            throw new Exception("Arquivo [$filePath] já existe");

        $data = [
            '[#]',
            'name' => $commandName,
            'class' => $class,
            'namespace' => $namespace,
            'PHP' => '<?php'
        ];

        $base = path(dirname(__DIR__, 3) . '/library/template/command.txt');

        $content = Import::output($base, $data);

        File::create($filePath, $content);

        MxCmd::show('Comando [[#]] criado com sucesso.', $commandName);
    }
}