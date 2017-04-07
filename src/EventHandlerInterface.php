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

use Vainyl\Core\IdentifiableInterface;

/**
 * Interface EventHandlerInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventHandlerInterface extends IdentifiableInterface
{
    /**
     * @param EventInterface $event
     *
     * @return EventHandlerInterface
     */
    public function handle(EventInterface $event): EventHandlerInterface;
}