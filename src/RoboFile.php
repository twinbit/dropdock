<?php

use Symfony\Component\Finder\Finder as Finder;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    /**
     * Build containers from base repo.
     */
    public function build()
    {
      $this->yell("Drupal Docker build containers.");
      $standard_readme = file_get_contents('README.default.md');
      $finder = new Finder();
      $finder->directories()->in(__DIR__ . "/containers");
      $finder->depth('== 0');
      foreach ($finder as $dir) {
        $container_source_path = $dir->getRealPath();
        $container_name = $dir->getRelativePathname();
        $container_dest = realpath("github-repos/docker-drupal-{$container_name}");
        if (file_exists($container_dest)) {
          $container_readme = "{$container_dest}/README.md";
          $this->printTaskInfo('Syncing container:' . $container_name);
          $this->taskCopyDir([$container_source_path => $container_dest])->run();
          // Update README files.
          if (file_exists($container_readme)) {
            $readme = file_get_contents($container_readme);
            $readme_replace = str_replace('***REPLACE***', $readme, $standard_readme);
            $this->taskWriteToFile($container_readme)
              ->text($readme_replace)
              ->run();
          }
        }
      }
    }

    /**
     * Commit to gihub.
     */
    public function commit()
    {
      $this->yell("Drupal Docker commit to gihub.");
      $finder = new Finder();
      $finder->directories()->in(__DIR__ . "/containers");
      $finder->depth('== 0');
      $update_time = time();
      foreach ($finder as $dir) {
        $container_source_path = $dir->getRealPath();
        $container_name = $dir->getRelativePathname();
        $container_dest = realpath("github-repos/docker-drupal-{$container_name}");
        if (file_exists($container_dest)) {
          $this->taskGitStack()
           ->stopOnFail()
           ->dir($container_dest)
           ->add('-A')
           ->commit('automatic update container from build: ' . $update_time)
           ->push('origin','master')
           ->run();
        }
      }
    }
}
