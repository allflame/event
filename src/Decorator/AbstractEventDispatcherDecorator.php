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

use Vainyl\Event\EventDispatcherInterface;
use Vainyl\Event\EventInterface;

/**
 * Class AbstractEventDispatcherDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractEventDispatcherDecorator implements EventDispatcherInterface
{
    private $dispatcher;

    /**
     * AbstractEventDispatcherDecorator constructor.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        return $this->dispatcher->getId();
    }

    /**
     * @inheritDoc
     */
    public function dispatch(EventInterface $event): EventDispatcherInterface
    {
        return $this->dispatcher->dispatch($event);
    }
}