<?php

namespace myPHPnotes\Slacker;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

/**
 *  Slacker Service Provider
 */
class SlackerServiceProvider extends ServiceProvider
{
    
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
            $this->publishes([
                __DIR__.'/../config/slacker.php' => config_path('slacker.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_slacker_tables.php.stub' => $this->getMigrationFileName($filesystem, 'create_slacker_tables.php'),
            ], 'migrations');
        }
    }
    public function register()
    {
        
    }
    protected function getMigrationFileName(Filesystem $filesystem, $migrationFileName): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_slacker_tables.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_slacker_tables.php")
            ->flatMap(function ($path) use ($filesystem, $migrationFileName) {
                return $filesystem->glob($path.'*_'.$migrationFileName);
            })
            ->push($this->app->databasePath()."/migrations/{$timestamp}_{$migrationFileName}")
            ->first();
    }
}
