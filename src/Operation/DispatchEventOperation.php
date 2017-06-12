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

use Vainyl\Core\ResultInterface;
use Vainyl\Event\EventDispatcherInterface;
use Vainyl\Event\EventInterface;
use Vainyl\Operation\AbstractOperation;
use Vainyl\Operation\SuccessfulOperationResult;

/**
 * Class DispatchEventOperation
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class DispatchEventOperation extends AbstractOperation
{
    private $eventDispatcher;

    private $event;

    /**
     * DispatchEventOperation constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param EventInterface           $event
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, EventInterface $event)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->event = $event;
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $this->eventDispatcher->dispatch($this->event);

        return new SuccessfulOperationResult($this);
    }
}