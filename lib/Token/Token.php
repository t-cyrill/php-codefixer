<?php
namespace CodeFixer\Token;

class Token
{
    private $token  = null;
    private $string = null;
    private $line   = null;
    private $token_name = null;

    public function __construct($tokens = null) {
        if (is_array($tokens)) {
            $this->token    = $tokens[0];
            $this->string   = $tokens[1];
            $this->line     = $tokens[2];
            $this->token_name = token_name($tokens[0]);
        } else {
            $this->string = $tokens;
        }
    }

    public function __tostring()
    {
        if ($this->string === null) {
            return '';
        }
        return $this->string;
    }

    public function isComment()
    {
        return $this->token === T_COMMENT;
    }

    public function isNull()
    {
        return $this->token === null
            && $this->string === null
            && $this->line === null;
    }

    public function isDoubleQuote()
    {
        return $this->string === '"';
    }

    public function isFunction()
    {
        return $this->token === T_FUNCTION;
    }

    public function isCatch()
    {
        return $this->token === T_CATCH;
    }

    public function isTry()
    {
        return $this->token === T_TRY;
    }

    public function isNextSpaceControl()
    {
        switch ($this->token) {
            case T_CATCH:
            case T_DO:
            case T_ELSE;
            case T_ELSEIF:
            case T_FOR:
            case T_FOREACH:
            case T_IF:
            case T_SWITCH:
            case T_TRY:
            case T_WHILE:
                return true;
            default:
                return false;
        }
    }

    public function isControl()
    {
        switch ($this->token) {
            case T_BREAK:
            case T_CASE:
            case T_CATCH:
            case T_CONTINUE:
            case T_DO:
            case T_DEFAULT:
            case T_ENDIF:
            case T_ENDFOR:
            case T_ELSE;
            case T_ELSEIF:
            case T_ENDFOREACH:
            case T_ENDSWITCH:
            case T_ENDWHILE:
            case T_FOR:
            case T_FOREACH:
            case T_IF:
            case T_RETURN:
            case T_SWITCH:
            case T_TRY:
            case T_WHILE:
                return true;
            default:
                return false;
        }
    }

    public function isElse()
    {
        return $this->token === T_ELSE;
    }

    public function isSemiColon()
    {
        return $this->string === ';';
    }

    public function isStartBrace()
    {
        return $this->string === '{';
    }

    public function isEndBrace()
    {
        return $this->string === '}';
    }

    public function isStartParentheses()
    {
        return $this->string === '(';
    }

    public function isEndParentheses()
    {
        return $this->string === ')';
    }

    public function isWhiteSpace()
    {
        return $this->token === T_WHITESPACE;
    }

    public function isDoubleArrow()
    {
        return $this->token === T_DOUBLE_ARROW;
    }

    public function isComma()
    {
        return $this->string === ',';
    }

    public function isSpace()
    {
        return $this->string === ' ';
    }

    public function isIsset()
    {
        return $this->token === T_ISSET;
    }

    public function isConstantEscapedString()
    {
        return $this->token === T_CONSTANT_ENCAPSED_STRING;
    }

    public function isCurlyOpen()
    {
        return ($this->token === T_DOLLAR_OPEN_CURLY_BRACES || $this->token === T_CURLY_OPEN);
    }

    public function isStringVarname()
    {
        return $this->token === T_STRING_VARNAME;
    }

    public function isCast()
    {
        switch ($this->token) {
            case T_ARRAY_CAST:
            case T_BOOL_CAST:
            case T_DOUBLE_CAST:
            case T_INT_CAST:
            case T_OBJECT_CAST:
            case T_STRING_CAST:
            case T_UNSET_CAST:
                return true;
            default:
                return false;
        }
    }

    public function isOperator()
    {
        switch ($this->string) {
            case '=':
            case '<':
            case '>':
            case '*':
            case '+':
            case '-':
            case '/':
            case '%':
                return true;
            default:
        }

        switch ($this->token) {
            case T_BOOLEAN_AND:
            case T_BOOLEAN_OR:
            case T_CONCAT_EQUAL:
            case T_DIV_EQUAL:
            case T_IS_EQUAL:
            case T_IS_GREATER_OR_EQUAL:
            case T_IS_IDENTICAL:
            case T_IS_NOT_EQUAL:
            case T_IS_NOT_IDENTICAL:
            case T_IS_SMALLER_OR_EQUAL:
            case T_LOGICAL_AND:
            case T_LOGICAL_OR:
            case T_LOGICAL_XOR:
            case T_MINUS_EQUAL:
            case T_MOD_EQUAL:
            case T_MUL_EQUAL:
            case T_PLUS_EQUAL:
            case T_SL:
            case T_SL_EQUAL:
            case T_SR:
            case T_SR_EQUAL:
            case T_XOR_EQUAL:
                return true;
            default:
                return false;
        }
    }
}


