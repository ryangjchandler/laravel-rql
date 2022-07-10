<?php

namespace RyanChandler\Rql;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Traits\Macroable;
use RyanChandler\Rql\Parser\Lexer;
use RyanChandler\Rql\Parser\Parser;

class Rql
{
    use Macroable;

    /** @var array<class-string<\Illuminate\Database\Eloquent\Model>> */
    protected array $bindings = [];

    public function compile(string $query): Builder
    {
        $lexer = new Lexer($query);
        $tokens = $lexer->tokenise();

        $parser = new Parser($tokens);

        $query = $parser->parse();
        $query->validate();

        $model = $this->bindings[$query->getUsing()] ?? null;

        if (! $model) {
            throw new Exception('Unrecognised binding: ' . $query->getUsing());
        }

        /** @var \Illuminate\Database\Eloquent\Builder */
        $builder = $model::query();
        $builder->select($query->getSelects());

        return $builder;
    }

    public function toArray(string $query): array
    {
        return $this->compile($query)->get()->toArray();
    }

    public function addBinding(string $class, string $alias = null): static
    {
        $this->bindings[$class] = $alias ?? class_basename($class);

        return $this;
    }
}
