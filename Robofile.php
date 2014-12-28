<?php

use Symfony\Component\Finder\Finder as Finder;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{

    public function build() {
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
            ->in(__DIR__);
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add binaries.
      $files = Finder::create()->ignoreVCS(true)
           ->files()
           ->in(__DIR__ . '/bin');
      foreach ($files as $file) {
        $packer->addFile($file->getRelativePathname(), $file->getRealPath());
      }

      // Add drocker binary and make it as executable.
      $packer->addFile('drocker', 'drocker')
             ->executable('drocker')
             ->run();
      $this->taskComposerInstall()
           ->printed(false)
           ->run();
    }
}
