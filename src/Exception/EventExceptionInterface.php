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

use Vainyl\Event\EventInterface;

/**
 * Interface EventExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventExceptionInterface extends \Throwable
{
    /**
     * @return EventInterface
     */
    public function getEvent() : EventInterface;
}