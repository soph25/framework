<?php

/**
 * Event file
 *
 * Copyright (c) 2016, Kiril Savchev
 * All rights reserved.
 *
 * @category Libs
 * @package EventManager
 *
 * @author Kiril Savchev <k.savchev@gmail.com>
 *
 * @license https://opensource.org/licenses/BSD-3-Clause BSD 3 License
 * @link http://ifthenelse.info
 */

namespace Framework\Events;

use Framework\Events\EventManager\EventInterface;

/**
 * Event
 *
 * @author Kiril Savchev <k.savchev@gmail.com>
 */
class Event implements EventInterface
{

    /**
     * The event name
     *
     * @var string
     */
    protected $name = "";

    /**
     * The event target
     *
     * @var mixed
     */
    protected $target;

    /**
     * The event parameters
     *
     * @var array
     */
    protected $params = [];

    /**
     * Flag that show whether the event must be stopped while triggering
     *
     * @var bool
     */
    protected $isPropagationStopped = false;

    /**
     * Create event object
     *
     * @param string $name [Optional] Event name
     * @param mixed $target [Optional] Event target
     * @param array $params [Optional] Event parameters
     */
    public function __construct($name = '', $target = null, array $params = [])
    {
        $this->name = $name;
        $this->target = $target;
        $this->params = $params;
    }

    /**
     * Gets the event name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets single parameter
     *
     * @param string $name
     * @return mixed
     */
    public function getParam($name)
    {
        return (array_key_exists($name, $this->params)) ? $this->params[$name] : null;
    }

    /**
     * Gets all parameters
     *
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Gets event target
     *
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Checks whetner the event is stopped
     *
     * @return bool
     */
    public function isPropagationStopped()
    {
        return $this->isPropagationStopped;
    }

    /**
     * Sets the event name
     *
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * Sets the event parameters
     *
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * Sets the event target
     *
     * @param mixed $target
     */
    public function setTarget($target)
    {
        $this->target = $target;
    }

    /**
     * Stops or resumes the event triggering
     *
     * @param bool $flag
     */
    public function stopPropagation($flag)
    {
        $this->isPropagationStopped = (bool) $flag;
    }
}
