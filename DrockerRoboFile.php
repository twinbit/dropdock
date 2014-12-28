<?php
use Symfony\Component\Finder\Finder as Finder;
class RoboFile extends \Robo\Tasks
{
    /**
     * Init drocker project.
     */
    public function init()
    {
      $this->yell("Drupal Docker init.");
      $base_path = __DIR__;
      if (strpos(basename(__FILE__), 'phar')) {
        $base_path = "phar://";
      }
      // Create directory structure.
      $this->taskFileSystemStack()
           ->mkdir('data')
           ->mkdir('bin')
           ->run();

      // Copy static binaries.
      $this->taskMirrorDir([$base_path . '/src/bin/' => 'bin/'])->run();

      // Rename fig.yml.dist to fig.yml
      #$this->taskFileSystemStack
      #     ->copy('fig.yml.dist', 'fig.yml')
      #     ->run();
    }
}
