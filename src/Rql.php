<?php

namespace RyanChandler\Rql;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\Macroable;
use RyanChandler\Rql\Parser\Lexer;

class Rql
{
    use Macroable;

    public function compile(string $query): Builder
    {
        $lexer = new Lexer($query);

        dd($lexer->tokenise());
    }
}
