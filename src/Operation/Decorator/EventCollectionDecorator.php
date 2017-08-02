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

use Vainyl\Core\ResultInterface;
use Vainyl\Event\Operation\CollectionEventDispatcherInterface;
use Vainyl\Operation\Collection\CollectionInterface;
use Vainyl\Operation\Collection\Decorator\AbstractCollectionDecorator;

/**
 * Class EventCollectionDecorator
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventCollectionDecorator extends AbstractCollectionDecorator
{
    private $eventDispatcher;

    /**
     * DoctrineCollectionDecorator constructor.
     *
     * @param CollectionInterface                $collection
     * @param CollectionEventDispatcherInterface $eventDispatcher
     */
    public function __construct(CollectionInterface $collection, CollectionEventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
        parent::__construct($collection);
    }

    /**
     * @inheritDoc
     */
    public function execute(): ResultInterface
    {
        $this->eventDispatcher->start();
        $result = parent::execute();
        if (false === $result->isSuccessful()) {
            return $result;
        }
        $this->eventDispatcher->flush();

        return $result;
    }
}