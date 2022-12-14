<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf5162375006f2fce93a5216182328b3f
{
    public static $files = array (
        '2dcc1fe700145c8f64875eb0ae323e56' => __DIR__ . '/../..' . '/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf5162375006f2fce93a5216182328b3f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf5162375006f2fce93a5216182328b3f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf5162375006f2fce93a5216182328b3f::$classMap;

        }, null, ClassLoader::class);
    }
}
