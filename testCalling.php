<?php
//
//class A {
//    function B() {
//        var_dump("text");
//    }
//}
//
//
//$instance = new A;
//$instance->B();
//
//
//(new A('cava'))->B();
//
//
//$f = array(new A, 'B');
//$f();

//$a = trim("lorem    ");
//$a = call_user_func('trim', 'lorem    ');
//$a = call_user_func_array('trim', array('lorem   '));
//$a = array('trim');
//$a('lorem   ');


class T {
    public function methodA($x) {
        var_dump($x);
    }
}

$t = new T;
$f = array($t, 'methodA');
$f(1);