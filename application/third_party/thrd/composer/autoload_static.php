<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitae616b30e22381e2cf244ed0b387d8ee
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mike42\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mike42\\' => 
        array (
            0 => __DIR__ . '/..' . '/mike42/escpos-php/src/Mike42',
            1 => __DIR__ . '/..' . '/mike42/gfx-php/src/Mike42',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitae616b30e22381e2cf244ed0b387d8ee::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitae616b30e22381e2cf244ed0b387d8ee::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
