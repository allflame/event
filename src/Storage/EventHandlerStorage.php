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

namespace Vainyl\Event\Storage;

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Queue\PriorityQueueInterface;
use Vainyl\Core\Storage\StorageInterface;
use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\Factory\EventHandlerFactoryInterface;

/**
 * Class EventHandlerStorage
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventHandlerStorage extends AbstractIdentifiable implements EventHandlerStorageInterface
{
    /**
     * @var StorageInterface|PriorityQueueInterface[]
     */
    private $handlerMap;

    /**
     * @var StorageInterface|StorageInterface[]
     */
    private $priorityMap;

    /**
     * @var \Vainyl\Core\Storage\StorageInterface
     */
    private $mapPrototype;

    /**
     * @var \Vainyl\Core\Queue\PriorityQueueInterface
     */
    private $queuePrototype;

    /**
     * @var \Vainyl\Event\Factory\EventHandlerFactoryInterface
     */
    private $handlerFactory;

    /**
     * EventHandlerStorage constructor.
     *
     * @param StorageInterface             $mapPrototype
     * @param PriorityQueueInterface       $queuePrototype
     * @param EventHandlerFactoryInterface $handlerFactory
     */
    public function __construct(
        StorageInterface $mapPrototype,
        PriorityQueueInterface $queuePrototype,
        EventHandlerFactoryInterface $handlerFactory
    ) {
        $this->handlerMap     = clone $mapPrototype;
        $this->priorityMap    = clone $mapPrototype;
        $this->mapPrototype   = $mapPrototype;
        $this->queuePrototype = $queuePrototype;
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * @inheritDoc
     */
    public function addHandler(
        string $eventName,
        EventHandlerInterface $eventHandler,
        int $priority = 0
    ): EventHandlerStorageInterface {
        if (false === $this->handlerMap->offsetExists($eventName)) {
            $this->handlerMap->offsetSet($eventName, clone $this->queuePrototype);
        }
        if (false === $this->priorityMap->offsetExists($eventName)) {
            $this->priorityMap->offsetSet($eventName, clone $this->mapPrototype);
        }
        $this->handlerMap[$eventName]->enqueue($eventHandler, $priority);
        $this->priorityMap[$eventName][$eventHandler] = $priority;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(string $eventName): array
    {
        if (false === $this->handlerMap->offsetExists($eventName)) {
            return [];
        }

        return $this->handlerMap[$eventName]->toArray();
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        $handlerMap = [];
        /**
         * @var PriorityQueueInterface $handlerQueue
         */
        foreach ($this->handlerMap as $eventName => $handlerQueue) {
            $handlerMap[$eventName] = $handlerQueue->toArray();
        }

        return new \ArrayIterator($handlerMap);
    }

    /**
     * @inheritDoc
     */
    public function getListenerPriority(string $eventName, EventHandlerInterface $eventHandler): int
    {
        if (false === $this->priorityMap->offsetExists($eventName)) {
            return 0;
        }

        if (false === $this->priorityMap[$eventName]->offsetExists($eventHandler)) {
            return 0;
        }

        return $this->priorityMap[$eventName][$eventHandler];
    }

    /**
     * @inheritDoc
     */
    public function hasListeners(string $eventName): bool
    {
        return $this->handlerMap->offsetExists($eventName) && 0 !== count($this->handlerMap[$eventName]);
    }

    /**
     * @inheritDoc
     */
    public function removeHandler(string $eventName, EventHandlerInterface $eventHandler): EventHandlerStorageInterface
    {
        if (false === $this->handlerMap->offsetExists($eventName)) {
            return $this;
        }

        if (false === $this->priorityMap->offsetExists($eventName)) {
            return $this;
        }

        $this->priorityMap[$eventName]->offsetUnset($eventHandler);
        $this->refillPriorityQueue($this->handlerMap[$eventName], $this->priorityMap[$eventName]);

        return $this;
    }

    /**
     * PriorityQueueInterface doesn't support offsetUnset. So, destruct all elements and refill by priority map
     *
     * @param PriorityQueueInterface $queue
     * @param StorageInterface       $priorityMap
     *
     * @return $this
     */
    private function refillPriorityQueue(PriorityQueueInterface $queue, StorageInterface $priorityMap): self
    {
        while ($queue->valid()) {
            $queue->dequeue();
        }

        foreach ($priorityMap as $eventHandler => $priority) {
            $queue->enqueue($eventHandler, $priority);
        }

        return $this;
    }
}
