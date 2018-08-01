<?php

/**
 * EventListenerManagerInterface file
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
 * EventListenerManagerInterface
 *
 * @author Kiril Savchev <k.savchev@gmail.com>
 */
interface EventListenerManagerInterface
{

    /**
     * Sets the event manager
     *
     * @param EventManager $eventManager
     * @return self
     */
    public function setEventManager(EventManagerInterface $eventManager);

    /**
     * Returns the event manager
     *
     * @return EventManager
     */
    public function getEventManager();

    /**
     * Attach a callback to event
     *
     * If $bindContext is provided then the current object must be bound as
     * a context to the provided callback.
     *
     * @param string $event
     * @param callable $callback
     * @param int $priority [Optional]
     * @param bool $bindContext [Optional]
     */
    public function addEventListener($event, $callback, $priority = 0, $bindContext = false);

    /**
     * Removes a callback, attached to event
     *
     * @param string $event
     * @param callable $callback
     */
    public function removeEventListener($event, $callback);

    /**
     * Triggers an event
     *
     * @param array|EventInterface $event
     * @param mixed $target [Optional]
     * @param array|object $params [Optional]
     * @return mixed
     */
    public function fireEvent($event, $target = null, $params = []);
}
