<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6e9abb0157a3b329223af351dc53ea03
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Class',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6e9abb0157a3b329223af351dc53ea03::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6e9abb0157a3b329223af351dc53ea03::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
