<?php

namespace Lpheller\TailwindScssPreset;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Ui\Presets\Preset;
use Symfony\Component\Finder\SplFileInfo;

class TailwindScssPreset extends Preset
{
    public static function install()
    {
        static::updatePackages();
        static::updateStyles();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::removeNodeModules();
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            'laravel-mix'           => '^6.0',
            'tailwindcss'           => '^2.0',
            'vue-template-compiler' => '^2.6.12',
            'sass'                  => '^1.27',
            'sass-loader'           => '^8.0',
        ], Arr::except($packages, [
            'bootstrap',
            'bootstrap-sass',
            'popper.js',
            'laravel-mix',
            'jquery',
        ]));
    }

    protected static function updateStyles()
    {
        tap(new Filesystem, function ($filesystem) {
            $filesystem->deleteDirectory(resource_path('css'));

            $filesystem->delete(public_path('css/app.css'));

            if (! $filesystem->isDirectory($directory = resource_path('sass'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        });

        copy(__DIR__.'/../stubs/resources/sass/app.scss', resource_path('sass/app.scss'));
    }

    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/../stubs/tailwind.config.js', base_path('tailwind.config.js'));

        copy(__DIR__.'/../stubs/webpack.mix.js', base_path('webpack.mix.js'));

    }

    protected static function updateWelcomePage()
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));


        tap(new Filesystem, function ($filesystem) {
            if (! $filesystem->isDirectory($directory = resource_path('views/components/layout'))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        });


        copy(__DIR__.'/../stubs/resources/views/components/layout/app.blade.php', resource_path('views/components/layout/app.blade.php'));

        copy(__DIR__.'/../stubs/resources/views/welcome.blade.php', resource_path('views/welcome.blade.php'));
    }
}
