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
use Vainyl\Core\Application\EnvironmentInterface;
use Vainyl\Core\Extension\AbstractExtension;
use Vainyl\Core\Extension\ExtensionStorageInterface;
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
     * @param StorageInterface          $storage
     * @param ExtensionStorageInterface $extensionStorage
     */
    public function __construct(
        StorageInterface $storage,
        ExtensionStorageInterface $extensionStorage
    ) {
        $this->storage = $storage;
        $this->extensionStorage = $extensionStorage;
    }

    /**
     * @param EnvironmentInterface $environment
     *
     * @return EventConfig
     */
    public function createConfig(EnvironmentInterface $environment): EventConfig
    {
        $configData = [];
        /**
         * @var AbstractExtension $extension
         */
        foreach ($this->extensionStorage->getIterator() as $extension) {
            $fileName = $extension->getConfigDirectory($environment) . 'event.yml';
            if (false === file_exists($fileName)) {
                continue;
            }

            $configData = array_merge($configData, Yaml::parse($fileName));
        }

        return new EventConfig($this->storage->fromArray($configData));
    }
}