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

use Symfony\Component\Yaml\Yaml;
use Vainyl\Core\Extension\AbstractExtension;
use Vainyl\Core\Storage\StorageInterface;

/**
 * Class EventConfigFactory
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventConfigFactory
{
    private $storage;

    private $extensionStorage;

    /**
     * EventConfigFactory constructor.
     *
     * @param StorageInterface $storage
     * @param \Traversable     $extensionStorage
     */
    public function __construct(
        StorageInterface $storage,
        \Traversable $extensionStorage
    ) {
        $this->storage = $storage;
        $this->extensionStorage = $extensionStorage;
    }

    /**
     * @return EventConfig
     */
    public function createConfig(): EventConfig
    {
        $configData = [];
        /**
         * @var AbstractExtension $extension
         */
        foreach ($this->extensionStorage as $extension) {
            $fileName = $extension->getConfigDirectory() . 'event.yml';
            if (false === file_exists($fileName)) {
                continue;
            }

            $configData = array_merge($configData, Yaml::parse($fileName));
        }

        return new EventConfig($this->storage->fromArray($configData));
    }
}