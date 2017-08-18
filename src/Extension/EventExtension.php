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

namespace Vainyl\Event\Extension;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Vainyl\Core\Exception\MissingRequiredServiceException;
use Vainyl\Core\Extension\AbstractExtension;
use Vainyl\Core\Extension\AbstractFrameworkExtension;
use Vainyl\Event\ProxyEventHandler;

/**
 * Class EventExtension
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventExtension extends AbstractFrameworkExtension
{
    /**
     * @inheritDoc
     */
    public function getCompilerPasses(): array
    {
        return [[new EventHandlerCompilerPass()]];
    }

    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container): AbstractExtension
    {
        parent::load($configs, $container);
        $eventConfiguration = $this->processConfiguration(new EventConfiguration(), $configs);
        if (false === $container->hasDefinition('event.handler.factory')) {
            throw new MissingRequiredServiceException($container, 'event.handler.factory');
        }

        foreach ($eventConfiguration as $eventName => $handlers) {
            $count = 0;
            foreach ($handlers as $handlerConfig) {
                $handlerDefinition = (new Definition(
                    ProxyEventHandler::class,
                    [$handlerConfig['handler'], new Reference('event.handler.factory')]
                ))
                    ->addTag(
                        'event.handler',
                        [
                            'event'    => $eventName,
                            'priority' => $handlerConfig['priority'],
                            'mode'     => $handlerConfig['mode'],
                        ]
                    );
                $container->setDefinition(sprintf('event.handler.proxy.%s.%d', $eventName, $count), $handlerDefinition);
                $count++;
            }
        }

        return $this;
    }
}