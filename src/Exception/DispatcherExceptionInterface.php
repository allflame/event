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

use Vainyl\Core\Exception\CoreExceptionInterface;
use Vainyl\Event\EventDispatcherInterface;

/**
 * Interface DispatcherExceptionInterface
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
interface DispatcherExceptionInterface extends CoreExceptionInterface
{
    /**
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher(): EventDispatcherInterface;
}