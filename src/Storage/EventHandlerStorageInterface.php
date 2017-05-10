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

use Vainyl\Core\IdentifiableInterface;
use Vainyl\Event\EventHandlerInterface;
use Vainyl\Event\EventInterface;

/**
 * Interface EventHandlerStorageInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventHandlerStorageInterface extends IdentifiableInterface
{
    /**
     * @param EventInterface $event
     *
     * @return EventHandlerInterface[]
     */
    public function getHandlers(EventInterface $event) : array;
}