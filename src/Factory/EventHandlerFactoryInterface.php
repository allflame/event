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

use Vainyl\Core\IdentifiableInterface;
use Vainyl\Event\EventHandlerInterface;

/**
 * Interface EventHandlerFactoryInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface EventHandlerFactoryInterface extends IdentifiableInterface
{
    /**
     * @param string $handlerName
     * @param string $mode
     *
     * @return EventHandlerInterface
     */
    public function create(string $handlerName, string $mode): EventHandlerInterface;
}