<?php

declare(strict_types = 1);

namespace Order\File\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Конфигурация модуля
 */
class FileConfiguration implements ConfigurationInterface
{
    /**
     * Возвращает конфигурацию модуля
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('file');
        $rootNode
            ->children()
                ->scalarNode('tmp_file_dir')->isRequired()->end()
                ->scalarNode('remote_mount_path')->isRequired()->end()
                ->scalarNode('webdav_server_address')->isRequired()->end()
                ->scalarNode('webdav_user')->isRequired()->end()
                ->scalarNode('webdav_password')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
