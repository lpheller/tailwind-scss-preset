<?php

namespace Lpheller\TailwindScssPreset;

use Laravel\Ui\UiCommand;
use Illuminate\Support\ServiceProvider;
use Lpheller\TailwindScssPreset\TailwindScssPreset;

class TailwindScssPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('tailwind-scss', function ($command) {
            TailwindScssPreset::install();

            $command->info('Tailwind SCSS scaffolding installed successfully.');

            $command->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
