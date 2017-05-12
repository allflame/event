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

use Vainyl\Core\AbstractIdentifiable;
use Vainyl\Event\Exception\MissingMethodException;

/**
 * Class AbstractEventHandler
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
abstract class AbstractEventHandler extends AbstractIdentifiable implements EventHandlerInterface
{
    /**
     * @inheritDoc
     */
    public function handle(EventInterface $event): EventHandlerInterface
    {
        $name = $event->getName();

        if (false === method_exists($name, $this)) {
            throw new MissingMethodException($this, $event, $name);
        }

        return call_user_func([$this, $name], $name);
    }
}