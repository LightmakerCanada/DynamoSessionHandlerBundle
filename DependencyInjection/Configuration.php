<?php

namespace Lightmaker\DynamoSessionHandlerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('lightmaker_dynamo_session_handler');

        $rootNode
            ->children()
                ->scalarNode('table_name')->end()
                ->scalarNode('hash_key')->end()
                ->scalarNode('session_lifetime')->end()
                ->booleanNode('consistent_read')->end()
                ->scalarNode('locking_strategy')->end()
                ->booleanNode('automatic_gc')->end()
                ->scalarNode('gc_batch_size')->end()
                ->scalarNode('gc_batch_size')->end()
                ->scalarNode('gc_operation_delay')->end()
                ->scalarNode('max_lock_wait_time')->end()
                ->scalarNode('min_lock_retry_microtime')->end()
                ->scalarNode('max_lock_retry_microtime')->end()
            ->end();

        return $treeBuilder;
    }

}
