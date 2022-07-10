<?php

namespace RyanChandler\Rql\Parser;

use function RyanChandler\Rql\todo;

class Lexer
{
    protected array $tokens = [];

    final public function __construct(
        protected string $query,
    ) {
    }

    public function tokenise(): array
    {
        $characters = str_split($this->query);

        for ($i = 0; $i < count($characters); $i++) {
            $character = $characters[$i];

            if (ctype_space($character)) {
                continue;
            }

            if ($type = $this->simpleCharacter($character)) {
                $this->tokens[] = new Token($type, $character);
            } elseif ($character === '-' && isset($characters[$i + 1]) && $characters[$i + 1] === '>') {
                $this->tokens[] = new Token(TokenType::Arrow, '->');
                $i++;
            } elseif ($character === '\'') {
                $buffer = '';

                while (true) {
                    $next = $characters[$i + 1] ?? null;

                    if (! isset($next) || $next === '\'') {
                        break;
                    }

                    $buffer .= $next;
                    $i++;
                }

                $this->tokens[] = new Token(TokenType::String, $buffer);
            } elseif (is_numeric($character)) {
                $buffer = $character;

                while (true) {
                    $next = $characters[$i + 1] ?? null;

                    if (! isset($next)) {
                        break;
                    }

                    // TODO: Support floats!
                    if (! is_numeric($next) && $next !== '_') {
                        break;
                    }

                    $buffer .= $next;
                    $i++;
                }

                // TODO: Support floats!
                $this->tokens[] = new Token(TokenType::Number, (int) str_replace('_', '', $buffer));
            } elseif (ctype_alpha($character)) {
                $buffer = $character;

                while (true) {
                    $next = $characters[$i + 1] ?? null;

                    if (! isset($next)) {
                        break;
                    }

                    if (! ctype_alnum($next) && $next !== '_') {
                        break;
                    }

                    $buffer .= $next;
                    $i++;
                }

                $this->tokens[] = new Token(match ($buffer) {
                    'using' => TokenType::Using,
                    'select' => TokenType::Select,
                    default => TokenType::Identifier
                }, $buffer);
            }
        }

        return $this->tokens;
    }

    protected function simpleCharacter(string $character): ?TokenType
    {
        return match ($character) {
            ';' => TokenType::SemiColon,
            '{' => TokenType::LeftBrace,
            '}' => TokenType::RightBrace,
            ',' => TokenType::Comma,
            '(' => TokenType::LeftParen,
            ')' => TokenType::RightParen,
            default => null,
        };
    }
}
