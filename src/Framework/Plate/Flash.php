<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;

class Flash implements ExtensionInterface
{

    public function __construct(\Framework\Session\FlashService $flash)
    {
        $this->flash = $flash;
    }

    public function register(Engine $engine)
    {
        $engine->registerFunction('getFlash', [$this, 'getFlash']);
    }

    public function getFlash($type): ?string
    {
        return $this->flash->get($type);
    }
}
