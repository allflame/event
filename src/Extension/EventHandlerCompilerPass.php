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

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Vainyl\Core\Exception\MissingRequiredFieldException;
use Vainyl\Core\Exception\MissingRequiredServiceException;

/**
 * Class EventHandlerCompilerPass
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('event.handler.storage')) {
            throw new MissingRequiredServiceException($container, 'event.handler.storage');
        }

        $handlerStorageDefinition = $container->findDefinition('event.handler.storage');
        foreach ($container->findTaggedServiceIds('event.handler') as $id => $tags) {
            foreach ($tags as $attributes) {
                foreach (['event', 'priority', 'mode'] as $requiredAttribute) {
                    if (false === array_key_exists($requiredAttribute, $attributes)) {
                        throw new MissingRequiredFieldException($container, $id, $attributes, $requiredAttribute);
                    }
                }
                $handlerStorageDefinition
                    ->addMethodCall(
                        'addHandler',
                        [
                            $attributes['event'],
                            new Reference($id),
                            $attributes['priority'],
                        ]
                    );
            }
        }
    }
}