<?php

declare(strict_types = 1);

namespace Order\File\Compiler;

use Order\File\Adapter\WebDavAdapter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Подменяет WebDav адаптер в сервис-контейнере
 */
class WebDavAdapterOverrideCompiler implements CompilerPassInterface
{
    /**
     * Запускает компиляцию
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $definition = $container->getDefinition('oneup_flysystem.adapter.webdav');
        $definition->setClass(WebDavAdapter::class);
    }
}
