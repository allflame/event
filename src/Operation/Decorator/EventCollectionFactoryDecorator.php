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

namespace Vainyl\Event\Operation\Decorator;

use Vainyl\Event\Operation\CollectionEventDispatcherInterface;
use Vainyl\Operation\Collection\CollectionInterface;
use Vainyl\Operation\Collection\Decorator\AbstractCollectionFactoryDecorator;
use Vainyl\Operation\Collection\Factory\CollectionFactoryInterface;

/**
 * Class EventCollectionFactoryDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventCollectionFactoryDecorator extends AbstractCollectionFactoryDecorator
{
    private $eventDispatcher;

    /**
     * EventCollectionFactoryDecorator constructor.
     *
     * @param CollectionFactoryInterface         $collectionFactory
     * @param CollectionEventDispatcherInterface $eventDispatcher
     */
    public function __construct(
        CollectionFactoryInterface $collectionFactory,
        CollectionEventDispatcherInterface $eventDispatcher
    ) {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($collectionFactory);
    }

    /**
     * @inheritDoc
     */
    public function create(array $operations = []): CollectionInterface
    {
        return new EventCollectionDecorator(parent::create($operations), $this->eventDispatcher);
    }
}