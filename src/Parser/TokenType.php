<?php

namespace RyanChandler\Rql\Parser;

enum TokenType
{
    case Using;
    case Select;
    case Identifier;
    case SemiColon;
    case Comma;
    case LeftBrace;
    case RightBrace;
}
