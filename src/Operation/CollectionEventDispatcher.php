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

namespace Vainyl\Event\Operation;

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Core\Storage\StorageInterface;
use Vainyl\Event\EventDispatcherInterface;
use Vainyl\Event\EventInterface;
use Vainyl\Event\Exception\LevelIntegrityDispatcherException;

/**
 * Class CollectionEventDispatcher
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class CollectionEventDispatcher extends AbstractIdentifiable implements CollectionEventDispatcherInterface
{
    private $storage;

    private $level = 0;

    private $eventDispatcher;

    /**
     * CollectionEventDispatcher constructor.
     *
     * @param StorageInterface         $storage
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(StorageInterface $storage, EventDispatcherInterface $eventDispatcher)
    {
        $this->storage = $storage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @inheritDoc
     */
    public function start(): CollectionEventDispatcherInterface
    {
        if (0 <= $this->level) {
            $this->level++;

            return $this;
        }

        throw new LevelIntegrityDispatcherException($this, $this->level);
    }

    /**
     * @inheritDoc
     */
    public function flush(): CollectionEventDispatcherInterface
    {
        $this->level--;

        if (0 < $this->level) {
            return $this;
        }

        if (0 > $this->level) {
            throw new LevelIntegrityDispatcherException($this, $this->level);
        }

        foreach ($this->storage->getIterator() as $event) {
            $this->eventDispatcher->dispatch($event);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event): EventDispatcherInterface
    {
        $this->storage->offsetSet($event->getId(), $event);

        return $this;
    }
}