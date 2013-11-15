<?php
namespace CodeFixer\CodeFixer;

use CodeFixer\Token\Token;
use CodeFixer\String\StringBuffer;

class WhiteSpaceFixer {
    public static function fix($contents) {
        $contents = self::fixStartParentheses($contents);
        $contents = self::fixEndParentheses($contents);
        $contents = self::fixBeforeSpace($contents);
        $contents = self::fixAfterSpace($contents);
        $contents = self::fixComma($contents);
        return $contents;
    }

    public static function _fix($contents, $closure, $closure2) {
        $tokens_array = token_get_all($contents);

        $tokens = array();
        $tokens[] = new Token;
        $tokens[] = new Token;
        foreach ($tokens_array as $t) {
            $tokens[] = new Token($t);
        }
        $tokens[] = new Token;

        $print_buffer = new StringBuffer;
        $count = count($tokens);
        $in_string = false;

        for ($position = 1; $position < $count; $position++) {
            $token = $tokens[$position];
            $print_string = (string) $token;

            $result = true;
            if ($token->isDoubleQuote()) {
                $in_string = !$in_string;
            } elseif ($in_string) {
            } elseif ($closure($token)) {
                $result = $closure2($tokens, $position, $print_string, $print_buffer);
            }

            if ($result !== false) {
                $print_buffer->append($print_string);
            }
        }
        return $print_buffer->__toString();
    }

    public static function fixComma($contents)
    {
        return self::_fix($contents,
            function ($token) {
                return $token->isComma();
            },
            function ($tokens, &$position, &$print_string, $print_buffer) {
                $next_token = $tokens[$position + 1];
                $next_string = (string) $next_token;
                if (preg_match('/\A +\Z/', $next_string) === 0 && $next_string[0] !== "\n") {
                    $print_string = "$print_string ";
                }
                return true;
            }
        );
    }

    public static function fixAfterSpace($contents)
    {
        return self::_fix($contents,
            function ($token) {
                return $token->isOperator()
                    || $token->isDoubleArrow()
                    || $token->isFunction()
                    || $token->isNextSpaceControl()
                    || $token->isCast();
            },
            function ($tokens, &$position, &$print_string, $print_buffer) {
                $token = $tokens[$position];

                $next_token = $tokens[$position + 1];
                $next_string = (string) $next_token;
                if (preg_match('/\A +\Z/', $next_string) === 0) {
                    if (($token->isOperator() || $token->isDoubleArrow()) && $next_string[0] === "\n") {
                    } else {
                        $print_string = "$print_string ";
                    }
                }
                return true;
            }
        );
    }

    public static function fixBeforeSpace($contents)
    {
        return self::_fix($contents,
            function ($token) {
                return $token->isOperator()
                    || $token->isDoubleArrow()
                    || $token->isCatch()
                    || $token->isElse()
                    || $token->isStartBrace();
            },
            function ($tokens, &$position, &$print_string, $print_buffer) {
                $prev_token = $tokens[$position - 1];
                if (!$prev_token->isWhiteSpace()) {
                    $print_string = " $print_string";
                }
                return true;
            }
        );
    }

    /**
     * 丸括弧( の修正
     */
    public static function fixStartParentheses($contents)
    {
        return self::_fix($contents,
            function ($token) {
                return $token->isStartParentheses();
            },
            function ($tokens, &$position, &$print_string, $print_buffer) {
                $next_token = $tokens[$position + 1];
                $position++;

                $splited = explode("\n", $next_token, 2);
                $splited[0] = ltrim($splited[0], " \t");

                $print_string .= (string) implode("\n", $splited);
                $print_buffer->append($print_string);

                return false;
            }
        );
    }

    /**
     * 丸括弧) の修正
     */
    public static function fixEndParentheses($contents)
    {
        return self::_fix($contents,
            function ($token) {
                return $token->isEndParentheses();
            },
            function ($tokens, &$position, &$print_string, $print_buffer) {
                $double_prev_token  = $tokens[$position - 2];
                $prev_token         = $tokens[$position - 1];
                $prev_string        = (string) $prev_token;

                if ($prev_string[0] !== "\n" && !$double_prev_token->isComment()) {
                    $print_buffer->rtrim(" \t");
                }

                return true;
            }
        );
    }
}

