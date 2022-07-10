<?php

namespace RyanChandler\Rql\Parser;

use Exception;

class Query
{
    protected ?string $using = null;

    protected array $selects = [];

    public function setUsing(string $using): static
    {
        $this->using = $using;

        return $this;
    }

    public function getUsing(): string
    {
        return $this->using;
    }

    public function addSelect(string $select): static
    {
        $this->selects[] = $select;

        return $this;
    }

    public function getSelects(): array
    {
        return $this->selects;
    }

    public function validate(): void
    {
        if ($this->using === null) {
            throw new Exception('Missing using statement.');
        }

        if (count($this->selects) === 0) {
            throw new Exception('No selects added.');
        }
    }
}
