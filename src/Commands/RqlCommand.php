<?php

namespace RyanChandler\Rql\Commands;

use Illuminate\Console\Command;

class RqlCommand extends Command
{
    public $signature = 'laravel-rql';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
