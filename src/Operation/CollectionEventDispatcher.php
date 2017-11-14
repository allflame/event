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
use Vainyl\Core\Queue\QueueInterface;
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
    private $queue;

    private $level = 0;

    private $eventDispatcher;

    /**
     * CollectionEventDispatcher constructor.
     *
     * @param QueueInterface         $queue
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(QueueInterface $queue, EventDispatcherInterface $eventDispatcher)
    {
        $this->queue = $queue;
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

        while ($event = $this->queue->dequeue()) {
            $this->eventDispatcher->dispatch($event);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event): EventDispatcherInterface
    {
        $this->queue->enqueue($event);

        return $this;
    }
}
