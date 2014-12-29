<?php
use Symfony\Component\Finder\Finder as Finder;
class RoboFile extends \Robo\Tasks
{
    /**
     * Init drocker project.
     */
    public function init()
    {
      $this->yell("Drocker init.");
      $base_path = __DIR__;
      $phar = FALSE;
      if (strpos(__FILE__, 'phar://') !== FALSE) {
        $base_path = 'phar://drocker.phar';
        $phar = TRUE;
      }
      // Create directory structure.
      $this->taskFileSystemStack()
           ->mkdir('data')
           ->mkdir('bin')
           ->run();

      // Copy static binaries.
      if ($phar) {
        $bin_dir = $base_path . '/bin/';
      }
      else {
        $bin_dir = $base_path . '/src/bin/';
      }
      $this->taskMirrorDir([$bin_dir => 'bin/'])->run();

      // Rename fig.yml.dist to fig.yml
      $this->taskFileSystemStack()
           ->copy($base_path . '/fig.yml.dist', 'fig.yml')
           ->run();
    }
}
