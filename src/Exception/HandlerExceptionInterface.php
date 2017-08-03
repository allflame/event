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

namespace Vainyl\Event\Exception;

use Vainyl\Event\EventHandlerInterface;

/**
 * Interface HandlerExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface HandlerExceptionInterface extends \Throwable
{
    /**
     * @return EventHandlerInterface
     */
    public function getEventHandler(): EventHandlerInterface;
}