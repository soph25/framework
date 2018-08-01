<?php
namespace Framework\Router;

/**
 * Class Route
 * Represent a matched route
 */
class Route
{

    
     /**
     * @var string
     */
    private $path;

    /**
     * @var callable
     */
    private $callback;


    
    private $name;
    

    /**
     * @var array
     */
    private $parameters;

    public function __construct(string $name, $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }
    /**
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }
   
    

    /**
     * Retrieve the URL parameters
     * @return string[]
     */
    public function getParams()
    {
        return $this->parameters;
    }
}
