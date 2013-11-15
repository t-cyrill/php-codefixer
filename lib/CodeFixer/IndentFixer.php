<?php
namespace CodeFixer\CodeFixer;

use CodeFixer\Token\Token;
use CodeFixer\String\StringBuffer;

class IndentFixer {
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
}

