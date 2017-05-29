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

namespace Vainyl\Event\Config;

use Vainyl\Core\Storage\Decorator\AbstractStorageDecorator;

/**
 * Class EventConfig
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventConfig extends AbstractStorageDecorator
{
    /**
     * @param array $configData
     *
     * @return EventConfig
     */
    public function addConfig(array $configData)
    {
        $handlers = [];
        foreach ($configData as $section => $events) {
            foreach ($events as $name => $config) {
                $handlers[sprintf('%s%s%s', $section, ':', $name)][] = $name;
            }
        }

        foreach ($handlers as $eventName => $aliases) {
            if (false === $this->offsetExists($eventName)) {
                $this->offsetSet($eventName, $aliases);
            } else {
                $this->offsetSet($eventName, array_merge($this->offsetGet($eventName), $aliases));
            }
        }

        return $this;
    }
}