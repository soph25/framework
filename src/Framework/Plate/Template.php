<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Plate;

/**
 * @author Pablo Díez <pablodip@gmail.com>
 */
class Template 
{
    protected static $defaultOptions = array();

    public $routeGenerator;
    public $options;

    public function __construct()
    {
        $this->initializeOptions();
        //$this->setRouteGenerator($routeGenerator);
    }

    public function setRouteGenerator($routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;
    }

    public function setOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    public function initializeOptions()
    {
        $this->options = static::$defaultOptions;
    }

    public function generateRoute($page)
    {
        return call_user_func($this->getRouteGenerator(), $page);
    }

    public function getRouteGenerator()
    {
        if (!$this->routeGenerator) {
            throw new \RuntimeException('There is no route generator.');
        }

        return $this->routeGenerator;
    }

    public function option($name)
    {
        if (!isset($this->options[$name])) {
            throw new \InvalidArgumentException(sprintf('The option "%s" does not exist.', $name));
        }

        return $this->options[$name];
    }
}
