<?php

use Symfony\Component\Finder\Finder as Finder;

/**
 * This is project's console commands configuration for Drocker command.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{

  public function release()
    {
        $this->yell("Releasing Drocker");
        $this->taskGitStack()
            ->add('-A')
            ->commit("auto-update")
            ->pull()
            ->push()
            ->run();
        $this->taskGitHubRelease(\Twinbit\DrockerRunner::VERSION)
            ->uri('twinbit/drocker')
            ->askDescription()
            ->run();
        $this->pharPublish();
        $this->versionBump();
    }

    /**
     * Build the Drocker phar package
     */
    public function pharBuild() {
      $packer = $this->taskPackPhar('drocker.phar');
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
            ->in(__DIR__);
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add binaries.
      $files = Finder::create()->ignoreVCS(true)
           ->files()
           ->path('bin')
           ->notPath('data')
           ->notPath('vendor')
           ->notPath('src')
           ->in(__DIR__);
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add drocker binary and make it as executable.
      $packer->addFile('DrockerRoboFile.php', 'DrockerRoboFile.php');
      $packer->addFile('drocker', 'drocker')
             ->executable('drocker')
             ->run();
      $this->taskComposerInstall()
           ->printed(false)
           ->run();
    }

    public function pharPublish()
    {
        $this->pharBuild();
        rename('drocker.phar', 'drocker-release.phar');
        $this->taskGitStack()->checkout('gh-pages')->run();
        rename('drocker-release.phar', 'drocker.phar');
        $this->taskGitStack()
            ->add('drocker.phar')
            ->commit('drocker.phar published')
            ->push('origin','gh-pages')
            ->checkout('master')
            ->run();
    }

    public function versionBump($version = null)
    {
        if (!$version) {
            $versionParts = explode('.', \Twinbit\DrockerRunner::VERSION);
            $versionParts[count($versionParts)-1]++;
            $version = implode('.', $versionParts);
        }
        $this->taskReplaceInFile(__DIR__.'/php-src/DrockerRunner.php')
            ->from("VERSION = '".\Twinbit\DrockerRunner::VERSION."'")
            ->to("VERSION = '".$version."'")
            ->run();
    }

}
