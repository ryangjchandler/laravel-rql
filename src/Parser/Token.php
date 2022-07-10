<?php

namespace RyanChandler\Rql\Parser;

use Stringable;

class Token implements Stringable
{
    final public function __construct(
        public readonly TokenType $type,
        public readonly string $literal,
    ) {}

    public function __toString(): string
    {
        return $this->literal;
    }
}
