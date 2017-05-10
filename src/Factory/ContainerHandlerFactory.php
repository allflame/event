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

namespace Vainyl\Event\Factory;

use Psr\Container\ContainerInterface;
use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Event\EventHandlerInterface;

/**
 * Class EventHandlerFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class ContainerHandlerFactory extends AbstractIdentifiable implements EventHandlerFactoryInterface
{
    private $container;

    /**
     * ContainerHandlerFactory constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function create(string $handlerName): EventHandlerInterface
    {
        return $this->container->get($handlerName);
    }
}