<?php
namespace Framework;


class Foo {
    private $objects = array();
 
    public function __construct() {
    }
 
    public function __get($v){
        if (array_key_exists($v, $this->objects)) {
            return $this->objects[$v];
        } else {
            return null;
        }
    }
 
    public function __set($k, $v) {
        $this->objects[$k] = $v;
        return $this;
    }
 
    public function __call($func, $args) {
        return call_user_func($this->objects[$func], $args);
    }
}
