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

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class EventConfiguration
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class EventConfiguration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('event');

        $rootNode
            ->children()
                ->arrayNode('source')
                    ->children()
                        ->scalarNode('type')
                        ->arrayNode('options')
                            ->prototype('scalar')->end()
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->arrayNode('events')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('handler')->end()
                            ->scalarNode('mode')->end()
                        ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}