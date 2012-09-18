<?php

namespace Sauce\Composer;

use Composer\Package\PackageInterface;
use Composer\Installer\LibraryInstaller;

class SausageInstaller extends LibraryInstaller
{
    public function supports($packageType)
    {
        return 'sauce-sausage' === $packageType;
    }

    public function updateCode(PackageInterface $initial, PackageInterface $target)
    {
        $path = $this->getInstallPath($initial);
        $config_file = $path.'/.sauce_config';
        $contents = null;

        if (is_file($config_file)) {
            $this->io->write("    Backing up Sauce config");
            $contents = file_get_contents($config_file);
        }

        parent::updateCode($initial, $target);

        if ($contents) {
            $this->io->write("    Restoring Sauce config");
            file_put_contents($config_file, $contents);
        } elseif (getenv('SAUCE_USERNAME') && getenv('SAUCE_ACCESS_KEY')) {
            $this->io->write("Generating Sauce config based on environment variables");
            file_put_contents($config_file, getenv('SAUCE_USERNAME').','.
                getenv('SAUCE_ACCESS_KEY'));
        } else {
            $this->io->write("<warning>    No Sauce config file found. Please run vendor/bin/sauce_config USERNAME API_KEY</warning>");
        }
    }
}
