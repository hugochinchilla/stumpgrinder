<?php
namespace Hchinchilla\DockerComposer;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class DockerComposerPlugin implements PluginInterface, EventSubscriberInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->io = $io;
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
    }

    public static function getSubscribedEvents()
    {
        return array(
            'post-package-install' => 'fixOwnership',
            'post-package-update' => 'fixOwnership',
            'post-file-download' => 'fixOwnership'
        );
    }

    private function fixOwnership()
    {
        $isRoot = posix_getuid() === 0;
        $this->io->info("IT WORKS {$isRoot}");
        //die;
    }
}