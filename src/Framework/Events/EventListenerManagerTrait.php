<?php

/**
 * EventListenerManagerTrait file
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
use Framework\Events\EventManager\EventManagerInterface;

/**
 * EventListenerManagerTrait
 *
 * @author Kiril Savchev <k.savchev@gmail.com>
 */
trait EventListenerManagerTrait
{

    /**
     * The actual event manager
     *
     * @var EventManager
     */
    protected $eventManager;

    /**
     * Sets the event manager
     *
     * @param EventManager $eventManager
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }

    /**
     * Returns the event manager
     *
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->eventManager;
    }

    /**
     * Attach a callback to event
     *
     * If $bindContext is provided then the current object is bound as
     * object context ($this) to the provided callback.
     *
     * @param string $event
     * @param callable $callback
     * @param int $priority
     * @param bool $bindContext
     */
    public function addEventListener($event, $callback, $priority = 0, $bindContext = false)
    {
        if ($bindContext) {
            $callback = \Closure::bind($callback, $this, get_class($this));
        }
        return $this->eventManager->attach($event, $callback, $priority);
    }

    /**
     * Triggers an event
     *
     * @param array|EventInterface $event
     * @param mixed $target
     * @param array|object $params
     * @return mixed
     */
    public function fireEvent($event, $target = null, $params = [])
    {
        return $this->eventManager->trigger($event, $target, $params);
    }

    /**
     * Removes a callback, attached to event
     *
     * @param string $event
     * @param callable $callback
     */
    public function removeEventListener($event, $callback)
    {
        return $this->eventManager->detach($event, $callback);
    }
}
