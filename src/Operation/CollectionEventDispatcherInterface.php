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

use Vainyl\Event\EventDispatcherInterface;

/**
 * Class CollectionEventDispatcherInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface CollectionEventDispatcherInterface extends EventDispatcherInterface
{
    /**
     * @return CollectionEventDispatcherInterface
     */
    public function start(): CollectionEventDispatcherInterface;

    /**
     * @return CollectionEventDispatcherInterface
     */
    public function flush(): CollectionEventDispatcherInterface;
}