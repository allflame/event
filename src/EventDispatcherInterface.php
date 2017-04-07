<?php
/**
 * Vainyl
 *
 * PHP Version 7
 *
 * @package   Event
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://vainyl.com
 */
declare(strict_types=1);

namespace Vainyl\Event;

/**
 * Interface EventDispatcherInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventDispatcherInterface
{
    /**
     * @param EventInterface $event
     *
     * @return EventDispatcherInterface
     */
    public function dispatch(EventInterface $event) : EventDispatcherInterface;
}