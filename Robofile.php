<?php
include 'vendor/autoload.php';
use Symfony\Component\Finder\Finder as Finder;
use Symfony\Component\Yaml\Parser as Parser;

/**
 * This is project's console commands configuration for the Dropdock project.
 */
class Robofile extends \Robo\Tasks
{

  public function release()
    {
        $this->yell("Releasing Dropdock");
        $this->taskExecStack()
          ->stopOnFail()
          ->exec("git submodule update --init --recursive --remote")
          ->run();
        $this->taskGitStack()
            ->add('-A')
            ->commit("auto-update")
            ->pull()
            ->push()
            ->run();
        $this->taskGitHubRelease(\Twinbit\DropdockRunner::VERSION)
            ->uri('twinbit/dropdock')
            ->askDescription()
            ->run();
        $this->pharPublish();
        $this->versionBump();
    }

    /**
     * Build the Dropdock phar package
     */
    public function pharBuild()
    {
      $yaml = new Parser();
      $packer = $this->taskPackPhar('dropdock.phar');
      // $packer->compress(TRUE);
      $this->taskComposerInstall()
            ->noDev()
            ->printed(false)
            ->run();

      // Add php sources.
      $files = Finder::create()->ignoreVCS(true)
            ->files()
            ->name('*.php')
            ->path('php-src')
            ->path('vendor')
            ->notPath('data')
            ->notPath('tmp')
            ->in(__DIR__);
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add binaries yaml config.
      $files = Finder::create()->ignoreVCS(true)
           ->files()
           ->name('binaries.yml')
           ->in(__DIR__);
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add dropdock binary and make it as executable.
      $packer->addFile('DropdockRoboFile.php', 'DropdockRoboFile.php');
      // Add docker-compose.yml.
      $packer->addFile('docker-compose.yml.dist', 'docker-compose.yml.dist');

      // Add boot2local.sh script.
      $packer->addFile('src/scripts/boot2local.sh', 'src/scripts/boot2local.sh');

      $packer->addFile('dropdock', 'dropdock')
             ->executable('dropdock')
             ->run();
      $this->taskComposerInstall()
           ->printed(false)
           ->run();
    }

    public function pharPublish()
    {
        $this->pharBuild();
        rename('dropdock.phar', 'dropdock-release.phar');
        $this->taskGitStack()->checkout('gh-pages')->run();
        rename('dropdock-release.phar', 'dropdock.phar');
        $this->taskGitStack()
            ->add('dropdock.phar')
            ->commit('dropdock.phar published')
            ->push('origin','gh-pages')
            ->checkout('master')
            ->run();
    }

    public function versionBump($version = null)
    {
        if (!$version) {
            $versionParts = explode('.', \Twinbit\dropdockRunner::VERSION);
            $versionParts[count($versionParts)-1]++;
            $version = implode('.', $versionParts);
        }
        $this->taskReplaceInFile(__DIR__.'/php-src/DropdockRunner.php')
            ->from("VERSION = '".\Twinbit\dropdockRunner::VERSION."'")
            ->to("VERSION = '".$version."'")
            ->run();
    }

}
