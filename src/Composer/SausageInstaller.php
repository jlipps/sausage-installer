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
}
