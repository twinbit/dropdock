<?php
use Symfony\Component\Finder\Finder as Finder;

/**
 * This is project's console commands configuration for the Drocker cli tool.
 */
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
      $bin_dir = $base_path . '/src/bin/';
      $this->taskMirrorDir([$bin_dir => 'bin/'])->run();

      // Rename fig.yml.dist to fig.yml
      $this->taskFileSystemStack()
           ->copy($base_path . '/fig.yml.dist', 'fig.yml')
           ->run();

      $uid = trim($this->taskExec('id -u')->run()->getMessage());
      $gid = trim($this->taskExec('id -g')->run()->getMessage());
      $this->taskReplaceInFile('fig.yml')
       ->from('##LOCAL_UID##')
       ->to($uid)
       ->run();
      $this->taskReplaceInFile('fig.yml')
       ->from('##LOCAL_GID##')
       ->to($gid)
       ->run();
    }
}
