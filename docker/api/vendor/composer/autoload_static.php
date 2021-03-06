<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb54da028acbd7a104d5d5c26e0565356
{
    public static $prefixLengthsPsr4 = array (
        'j' => 
        array (
            'jucksearm\\barcode\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'jucksearm\\barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/jucksearm/php-barcode',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb54da028acbd7a104d5d5c26e0565356::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb54da028acbd7a104d5d5c26e0565356::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb54da028acbd7a104d5d5c26e0565356::$classMap;

        }, null, ClassLoader::class);
    }
}
