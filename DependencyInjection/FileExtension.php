<?php

declare(strict_types = 1);

namespace Order\File\DependencyInjection;

use Sabre\DAV\Client;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Загрузчик модуля
 */
class FileExtension extends Extension
{
    /**
     * Инициализирует конфигурацию модуля
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->createConfiguration(), $configs);
        $container->setParameter('tmp_file_dir', $config['tmp_file_dir']);

        $this->injectSabreDavClient(
            $container,
            $config['webdav_server_address'],
            $config['webdav_user'],
            $config['webdav_password']
        );

        $dirName = __DIR__.'/../Resources/config/';
        $loader  = new YamlFileLoader($container, new FileLocator($dirName));
        $loader->load('services.yml');
    }

    /**
     * Включает webDav клиент sabreDav
     *
     * @param ContainerBuilder $container
     * @param string           $baseUrl
     * @param string           $user
     * @param string           $password
     */
    private function injectSabreDavClient(
        ContainerBuilder $container,
        string $baseUrl,
        string $user,
        string $password
    ) {
        $params     = [
            'baseUri'  => $baseUrl,
            'userName' => $user,
            'password' => $password,
        ];
        $definition = new Definition(Client::class, [$params]);
        $container->setDefinition('file.webdav_client', $definition);
    }

    /**
     * Создает конфигурацию контейнера
     *
     * @return FileConfiguration
     */
    private function createConfiguration()
    {
        return new FileConfiguration();
    }
}
