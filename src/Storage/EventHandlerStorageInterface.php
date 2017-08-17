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

/**
 * Interface EventHandlerStorageInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventHandlerStorageInterface extends IdentifiableInterface
{
    /**
     * @param string                $eventName
     * @param EventHandlerInterface $eventHandler
     * @param int                   $priority
     *
     * @return EventHandlerStorageInterface
     */
    public function addHandler(
        string $eventName,
        EventHandlerInterface $eventHandler,
        int $priority = 0
    ): EventHandlerStorageInterface;

    /**
     * @param string $eventName
     *
     * @return EventHandlerInterface[]
     */
    public function getHandlers(string $eventName): array;

    /**
     * @param EventHandlerInterface $eventHandler
     *
     * @return int
     */
    public function getListenerPriority(string $eventName, EventHandlerInterface $eventHandler): int;

    /**
     * @param string $eventName
     *
     * @return bool
     */
    public function hasListeners(string $eventName): bool;

    /**
     * @param string                $eventName
     * @param EventHandlerInterface $eventHandler
     *
     * @return EventHandlerStorageInterface
     */
    public function removeHandler(string $eventName, EventHandlerInterface $eventHandler): EventHandlerStorageInterface;
}