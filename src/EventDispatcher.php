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

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Event\Storage\EventHandlerStorageInterface;

/**
 * Class EventDispatcher
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventDispatcher extends AbstractIdentifiable implements EventDispatcherInterface
{
    private $handlerStorage;

    /**
     * EventDispatcher constructor.
     *
     * @param EventHandlerStorageInterface $handlerStorage
     */
    public function __construct(EventHandlerStorageInterface $handlerStorage)
    {
        $this->handlerStorage = $handlerStorage;
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event): EventDispatcherInterface
    {
        foreach ($this->handlerStorage->getHandlers($event) as $handler) {
            $handler->handle($event);
        }

        return $this;
    }
}