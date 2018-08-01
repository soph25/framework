<?php
namespace Framework\Plate;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Framework\Middleware\CsrfMiddleware;


class Csrf  implements ExtensionInterface
{
    /**
     * @var CsrfMiddleware
     */
    private $csrfMiddleware;


    public function __construct(CsrfMiddleware $csrfMiddleware)
    {
        $this->csrfMiddleware = $csrfMiddleware;
    }

     public function register(Engine $engine)
    {
        $engine->registerFunction('csrf_input', [$this, 'csrf_input']);
        
    }

    public function csrf_input()
    {
        return '<input type="hidden" ' .
            'name="' . $this->csrfMiddleware->getFormKey() . '" ' .
            'value="' . $this->csrfMiddleware->generateToken() . '"/>';
    }
}
