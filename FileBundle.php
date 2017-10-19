<?php

declare(strict_types = 1);

namespace Order\File;

use Order\File\Compiler\WebDavAdapterOverrideCompiler;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Модуль файлового хранилища
 */
class FileBundle extends Bundle
{
    /**
     * Инициализирует контейнер
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new WebDavAdapterOverrideCompiler());
    }
}
