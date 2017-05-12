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

namespace Vainyl\Event\Decorator;

use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\EventInterface;

/**
 * Class AbstractEventHandlerDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractEventHandlerDecorator implements EventHandlerInterface
{
    private $eventHandler;

    /**
     * AbstractEventHandlerDecorator constructor.
     *
     * @param EventHandlerInterface $eventHandler
     */
    public function __construct(EventHandlerInterface $eventHandler)
    {
        $this->eventHandler = $eventHandler;
    }

    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event): EventHandlerInterface
    {
        $this->eventHandler->handle($event);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->eventHandler->getId();
    }
}