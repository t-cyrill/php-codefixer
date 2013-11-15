<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'CodeFixer\\CodeFixer\\WhiteSpaceFixer' => '/CodeFixer/WhiteSpaceFixer.php',
                'CodeFixer\\String\\StringBuffer' => '/String/StringBuffer.php',
                'CodeFixer\\Token\\Token' => '/Token/Token.php'
            );
        }
        if (isset($classes[$class])) {
            require __DIR__ . $classes[$class];
        }
     }
);
// @codeCoverageIgnoreEnd