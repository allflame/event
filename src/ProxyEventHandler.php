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
use Vainyl\Event\Factory\EventHandlerFactoryInterface;

/**
 * Class ProxyEventHandler
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ProxyEventHandler extends AbstractIdentifiable implements EventHandlerInterface
{
    private $instance;

    private $handlerAlias;

    private $handlerFactory;

    /**
     * ProxyEventHandler constructor.
     *
     * @param string                       $handlerAlias
     * @param EventHandlerFactoryInterface $handlerFactory
     */
    public function __construct(string $handlerAlias, EventHandlerFactoryInterface $handlerFactory)
    {
        $this->handlerAlias = $handlerAlias;
        $this->handlerFactory = $handlerFactory;
    }

    /**
     * @return EventHandlerInterface
     */
    public function getInstance(): EventHandlerInterface
    {
        if (null === $this->instance) {
            $this->instance = $this->handlerFactory->create($this->handlerAlias);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event): EventHandlerInterface
    {
        return $this->getInstance()->handle($event);
    }
}