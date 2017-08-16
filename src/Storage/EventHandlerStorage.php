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

use Vainyl\Core\Storage\Decorator\AbstractStorageDecorator;
use Vainyl\Core\Storage\StorageInterface;
use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\EventInterface;
use Vainyl\Event\Factory\EventHandlerFactoryInterface;

/**
 * Class EventHandlerStorage
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventHandlerStorage extends AbstractStorageDecorator implements EventHandlerStorageInterface
{
    private $eventConfig;

    private $handlerFactory;

    /**
     * EventHandlerStorage constructor.
     *
     * @param StorageInterface             $storage
     * @param StorageInterface             $eventConfig
     * @param EventHandlerFactoryInterface $handlerFactory
     */
    public function __construct(
        StorageInterface $storage,
        StorageInterface $eventConfig,
        EventHandlerFactoryInterface $handlerFactory
    ) {
        $this->eventConfig = $eventConfig;
        $this->handlerFactory = $handlerFactory;
        parent::__construct($storage);
    }

    /**
     * @inheritDoc
     */
    public function addHandler(string $eventName, EventHandlerInterface $eventHandler): EventHandlerStorageInterface
    {
        $this->eventConfig[$eventName][] = $eventHandler;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getHandlers(EventInterface $event): array
    {
        $eventHandlers = [];
        foreach ($this->eventConfig[$event->getName()] as $alias) {
            $eventHandlers[] = $this->offsetGet($alias);
        }

        return $eventHandlers;
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