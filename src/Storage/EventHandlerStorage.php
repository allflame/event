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

use Vainyl\Core\Queue\PriorityQueueInterface;
use Vainyl\Core\Storage\Decorator\AbstractStorageDecorator;
use Vainyl\Core\Storage\StorageInterface;
use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\Factory\EventHandlerFactoryInterface;

/**
 * Class EventHandlerStorage
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventHandlerStorage extends AbstractStorageDecorator implements EventHandlerStorageInterface
{
    private $eventConfig;

    private $priorityQueue;

    private $handlerFactory;

    /**
     * EventHandlerStorage constructor.
     *
     * @param StorageInterface             $storage
     * @param StorageInterface             $eventConfig
     * @param PriorityQueueInterface       $priorityQueue ,
     * @param EventHandlerFactoryInterface $handlerFactory
     */
    public function __construct(
        StorageInterface $storage,
        StorageInterface $eventConfig,
        PriorityQueueInterface $priorityQueue,
        EventHandlerFactoryInterface $handlerFactory
    ) {
        $this->eventConfig = $eventConfig;
        $this->priorityQueue = $priorityQueue;
        $this->handlerFactory = $handlerFactory;
        parent::__construct($storage);
    }

    /**
     * @inheritDoc
     */
    public function addHandler(
        string $eventName,
        EventHandlerInterface $eventHandler,
        int $priority = 0
    ): EventHandlerStorageInterface {
        if (false === $this->eventConfig->offsetExists($eventName)) {
            $this->eventConfig->offsetSet($eventName, clone $this->priorityQueue);
        }
        $this->eventConfig[$eventName]->enqueue($eventHandler, $priority);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(string $eventName): array
    {
        if (false === $this->offsetExists($eventName)) {
            return [];
        }

        return $this->eventConfig[$eventName]->toArray();
    }

    /**
     * @inheritDoc
     */
    public function hasListeners(string $eventName): bool
    {
        return $this->offsetExists($eventName) && [] !== $this->offsetGet($eventName);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        if (false === $this->offsetExists($offset)) {
            $this->offsetSet($offset, $this->handlerFactory->create($offset));
        }

        return parent::offsetGet($offset);
    }

    /**
     * @inheritDoc
     */
    public function removeHandler(string $eventName, EventHandlerInterface $eventHandler): EventHandlerStorageInterface
    {
        return $this;
    }
}