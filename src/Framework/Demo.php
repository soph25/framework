<?php
namespace Framework;


class Demo
{
  public function hello(): string
  {
    return "Salut";
  }


  public function bar($arg, $arg2) {
        echo __METHOD__, " got $arg and $arg2\n";
  }
}
