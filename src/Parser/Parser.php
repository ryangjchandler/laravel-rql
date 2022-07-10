<?php

namespace RyanChandler\Rql\Parser;

use Exception;

class Parser
{
    protected int $i;

    final public function __construct(
        protected array $tokens,
    ) {
    }

    public function parse(): Query
    {
        $query = new Query();

        for ($this->i = 0; $this->i < count($this->tokens); $this->i++) {
            $token = $this->current();

            if ($token->type === TokenType::Using) {
                if (! $this->expect(TokenType::Identifier)) {
                    throw new Exception('Expected identifier in using statement.');
                }

                $identifier = $this->next();

                $query->setUsing($identifier->literal);

                $this->semiColon();
            } elseif ($token->type === TokenType::Select) {
                $this->leftBrace();

                while ($this->peek()?->type !== TokenType::RightBrace) {
                    $next = $this->next();

                    if ($next->type === TokenType::Comma) {
                        continue;
                    }

                    if ($next->type !== TokenType::Identifier) {
                        throw new Exception('Expected identifier, got ' . $next->literal . '.');
                    }

                    // TODO: Make this support complex expressions like function calls / modifiers.
                    $query->addSelect($next->literal);
                }

                $this->rightBrace();
                $this->semiColon();
            }
        }

        return $query;
    }

    protected function current(): ?Token
    {
        return $this->tokens[$this->i] ?? null;
    }

    protected function peek(): ?Token
    {
        return $this->tokens[$this->i + 1] ?? null;
    }

    protected function next(): Token
    {
        $this->i++;

        return $this->tokens[$this->i];
    }

    protected function semiColon(): void
    {
        if (! $this->expect(TokenType::SemiColon)) {
            throw new Exception('Expected semi-colon.');
        }

        $this->next();
    }

    protected function leftBrace(): void
    {
        if (! $this->expect(TokenType::LeftBrace)) {
            throw new Exception('Expected left brace.');
        }

        $this->next();
    }

    protected function rightBrace(): void
    {
        if (! $this->expect(TokenType::RightBrace)) {
            throw new Exception('Expected right brace.');
        }

        $this->next();
    }

    protected function expect(TokenType $type): bool
    {
        return $this->peek()?->type === $type;
    }
}
