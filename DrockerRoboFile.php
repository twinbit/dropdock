<?php

use Symfony\Component\Finder\Finder as Finder;

/**
 * This is project's console commands configuration for the Drocker cli tool.
 */
class RoboFile extends \Robo\Tasks
{
    /**
     * Get internal base path.
     */
    private function getBasePath()
    {
      $base_path = getcwd();
      if (strpos(__DIR__, 'phar://') !== FALSE) {
        $base_path = 'phar://drocker.phar';
      }
      return $base_path;
    }

    /**
     * Init drocker project.
     */
    public function init()
    {
      $this->yell("Drocker init.");
      $base_path = $this->getBasePath();

      // Create directory structure.
      $this->taskFileSystemStack()
           ->mkdir('data')
           ->mkdir('bin')
           ->run();

      // Copy static binaries.
      $bin_dir = $base_path . '/src/bin/';
      $this->taskMirrorDir([$bin_dir => 'bin/'])->run();

      // Make binaries executables.
      $this->taskExec('chmod -R +x bin')->run();

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

       // @todo replace binaries $PWD with the static path of the project.
    }

    /**
     * Symlink www and bin folders.
     */
    public function symlink() {
      $this->taskFileSystemStack()
       ->symlink('data/var/www', 'www')
       ->run();
    }

    /**
     * Reconfigure boot2docker cpu/memory.
     */
    public function boot2dockerOptimize($opts = ['cpu' => '1', 'memory' => '8192'])
    {
      $memory = $opts['memory'];
      $cpu = $opts['cpu'];
      $this->taskExecStack()
       ->stopOnFail(TRUE)
       ->exec('boot2docker stop')
       ->exec('VBoxManage modifyvm "boot2docker-vm" --memory ' . $memory . ' --cpus ' . $cpu)
       ->exec('boot2docker up')
       ->run();
    }

    /**
     * Configure NFS mount boot script.
     */
    public function boot2dockerNfsSetup()
    {
      $base_path = $this->getBasePath();
      $mount_boot_script = file_get_contents($base_path . '/src/scripts/boot2local.sh');
      $this->taskExecStack()
       ->stopOnFail(TRUE)
       ->exec('boot2docker ssh "sudo rm /var/lib/boot2docker/bootlocal.sh && sudo touch /var/lib/boot2docker/bootlocal.sh"')
       ->exec('boot2docker ssh "echo \'' . $mount_boot_script . '\' | sudo tee -a /var/lib/boot2docker/bootlocal.sh" >/dev/null')
       ->exec('boot2docker restart')
       ->run();
    }
}
