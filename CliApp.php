<?php

namespace q\cliApp;

function line(string $line)
{
    echo PHP_EOL . $line . PHP_EOL;
    return true;
}

function syntax(string $line)
{

    echo PHP_EOL . "Invalid syntax. Please use:" . PHP_EOL;
    echo PHP_EOL . $line . PHP_EOL;
    return true;
}

function root()
{
    return realpath(__DIR__ . '/../') . DIRECTORY_SEPARATOR;
}

function dir()
{
    return realpath(__DIR__) . DIRECTORY_SEPARATOR;
}


class CliApp
{

    private $registry = [];

    function __get($name)
    {
        return $this->$name;
    }

    public function run(array $args, callable $onRun = null)
    {
        if ($onRun) $onRun();
        $arguments = array_slice($args, 1);
        $argsToString = trim(join(' ', $arguments));
        foreach ($this->registry as $command => $function) {
            if (preg_match("#$command#", $argsToString)) {
                $function($arguments);
                break;
            }
        }
        die;
    }

    public function registerCommand(string $regex, callable $function)
    {
        if ($this->registry[$regex] ?? false) {
            throw new \Error('Command Already Exists.');
        }
        $this->registry[$regex] = $function;
    }
}
