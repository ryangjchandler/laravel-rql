<?php

namespace RyanChandler\Rql;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RyanChandler\Rql\Commands\RqlCommand;

class RqlServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-rql')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-rql_table')
            ->hasCommand(RqlCommand::class);
    }
}
