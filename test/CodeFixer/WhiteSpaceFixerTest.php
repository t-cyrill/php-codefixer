<?php

use CodeFixer\CodeFixer\WhiteSpaceFixer;

class StackTest extends PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderForFix
     */
    public function testWhiteSpaceFixer($desc, $data)
    {
        extract($data);
        $actual = WhiteSpaceFixer::fix($code);
        self::assertEquals($expected, $actual);
    }

    public function dataProviderForFix()
    {
        $dataset = array(
            array('', array(
                'code' => <<<'EOD'
<?php
    for ($i = 0; $i<$limit*10; $i++) {
    }
    if (
        $a ||
        $b &&
        $c
    )
EOD
                ,'expected' => <<<'EOD'
<?php
    for ($i = 0; $i < $limit * 10; $i++) {
    }
    if (
        $a ||
        $b &&
        $c
    )
EOD
            )),
            array('', array(
                'code' => <<<'EOD'
<?php
class A{
    public static function test(A $hoge,B $huga){
        $a = array(array(),array());
        $a = array( array(),array() );
        $str= "string $a,$b,$c";
        $str= "string ${a},${b},${c}";
        $str="string {$a},{$b},{$c}";
        if(  $a  ){
            $a=0;
        }else{
            $b=1;
        }

        $a = array(
            'a'=>1, // ここはコメントです
            'b'=>2, /* コメント */
            'c'=>3, // ここもコメント
        );
        array(1,  2,  3);

        $f = function(){};

        switch ($a) {
            case 'A':
                continue;
            default:
                break;
        }
    }
}
EOD
                ,'expected' => <<<'EOD'
<?php
class A {
    public static function test(A $hoge, B $huga) {
        $a = array(array(), array());
        $a = array(array(), array());
        $str = "string $a,$b,$c";
        $str = "string ${a},${b},${c}";
        $str = "string {$a},{$b},{$c}";
        if ($a) {
            $a = 0;
        } else {
            $b = 1;
        }

        $a = array(
            'a' => 1, // ここはコメントです
            'b' => 2, /* コメント */
            'c' => 3, // ここもコメント
        );
        array(1,  2,  3);

        $f = function () {};

        switch ($a) {
            case 'A':
                continue;
            default:
                break;
        }
    }
}
EOD
            ))
        );

        return $dataset;
    }
}
