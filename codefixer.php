<?php
require __DIR__.'/lib/autoload.php';

$contents = file_get_contents('php://stdin');
echo \CodeFixer\CodeFixer\WhiteSpaceFixer::fix($contents);
