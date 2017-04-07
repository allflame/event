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

namespace Vainyl\Event\Exception;

use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\EventInterface;

/**
 * Class MissingMethodException
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class MissingMethodException extends AbstractHandlerException
{
    private $event;

    private $method;

    /**
     * MissingMethodException constructor.
     *
     * @param EventHandlerInterface $eventHandler
     * @param EventInterface        $event
     * @param string                $method
     */
    public function __construct(EventHandlerInterface $eventHandler, EventInterface $event, string $method)
    {
        $this->event = $event;
        $this->method = $method;
        parent::__construct(
            $eventHandler,
            sprintf(
                'Handler %s does not have method %s to handle event %s',
                $eventHandler->getId(),
                $method,
                $event->getName()
            )
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_merge(['event' => $this->event->getName(), 'method' => $this->method], parent::toArray());
    }
}