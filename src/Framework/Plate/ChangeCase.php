<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class ChangeCase implements ExtensionInterface
{
    public function register(Engine $engine)
    {
        $engine->registerFunction('case', [$this, 'getObject']);
    }

    public function getObject()
    {
        return $this;
    }

    public function upper($var)
    {
        return strtoupper($var);
    }

    public function lower($var)
    {
        return strtolower($var);
    }
}
