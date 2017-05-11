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
use Vainyl\Event\EventInterface;
use Vainyl\Event\Factory\EventHandlerFactoryInterface;

/**
 * Class EventHandlerStorage
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventHandlerStorage extends AbstractStorageDecorator implements EventHandlerStorageInterface
{
    private $handlerFactory;

    /**
     * EventHandlerStorage constructor.
     *
     * @param StorageInterface $storage
     * @param EventHandlerFactoryInterface $handlerFactory
     */
    public function __construct(
        StorageInterface $storage,
        EventHandlerFactoryInterface $handlerFactory
    )
    {
        $this->handlerFactory = $handlerFactory;
        parent::__construct($storage);
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
    public function getHandlers(EventInterface $event): array
    {
        return [];
    }
}