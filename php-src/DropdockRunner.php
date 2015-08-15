<?php

namespace Twinbit;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Robo\Runner;

class DropdockRunner extends \Robo\Runner {
    use \Robo\Output;
    const ROBOFILE = 'DropdockRoboFile.php';
    const VERSION = '0.1.13';
    protected function loadRoboFile()
    {
        $base_path = realpath(__DIR__ . '/../');
        if (strpos(__FILE__, 'phar://') !== FALSE) {
          $base_path = 'phar://dropdock.phar';
        }
        $conf_file = $base_path . '/' . self::ROBOFILE;
        if (!file_exists($conf_file)) {
            $this->writeln("<comment>  ".self::ROBOFILE." not found in this dir </comment>");
            exit;
        }
        require_once $conf_file;
        if (!class_exists(self::ROBOCLASS)) {
            $this->writeln("<error>Class ".self::ROBOCLASS." was not loaded</error>");
            return false;
        }
        return true;
    }

    public function execute()
    {
        register_shutdown_function(array($this, 'shutdown'));
        $app = new Application('Dropdock', self::VERSION);

        $loaded = $this->loadRoboFile();
        if (!$loaded) {
            $app->add(new Init('init'));
            $app->run();
            return;
        }
        $input = $this->prepareInput();

        $className = self::ROBOCLASS;
        $roboTasks = new $className;
        $taskNames = array_filter(get_class_methods(self::ROBOCLASS), function($m) {
            return !in_array($m, ['__construct']);
        });
        $passThrough = $this->passThroughArgs;
        foreach ($taskNames as $taskName) {
            $command = $this->createCommand($taskName);
            $command->setCode(function(InputInterface $input) use ($roboTasks, $taskName, $passThrough) {
                // get passthru args
                $args = $input->getArguments();
                array_shift($args);
                if ($passThrough) {
                    $args[key(array_slice($args, -1, 1, TRUE))] = $passThrough;
                }
                $args[] = $input->getOptions();
                $res = call_user_func_array([$roboTasks, $taskName], $args);
                if (is_int($res)) exit($res);
                if (is_bool($res)) exit($res ? 0 : 1);
                if ($res instanceof Result) exit($res->getExitCode());
            });
            $app->add($command);
        }
        $app->run($input);
    }
}
