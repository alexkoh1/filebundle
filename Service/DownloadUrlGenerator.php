<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Order\File\Embeddable\MetadataInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Сервис создания адресов для скачивания файлов
 */
class DownloadUrlGenerator implements DownloadUrlGeneratorInterface
{
    /**
     * Адрес хранилища
     *
     * @var string
     */
    private $frontRootUrl;

    /**
     * Сервис предоставления доступа к файлам по ключу
     *
     * @var TokenAccessibleStorageInterface
     */
    private $tokenAccessibleStorage;

    /**
     * Генератор адресов
     *
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * Конструктор
     *
     * @param TokenAccessibleStorageInterface $tokenAccessibleStorage
     * @param UrlGeneratorInterface           $urlGenerator
     * @param string                          $frontRootUrl
     */
    public function __construct(
        TokenAccessibleStorageInterface $tokenAccessibleStorage,
        UrlGeneratorInterface $urlGenerator,
        string $frontRootUrl
    ) {
        $this->tokenAccessibleStorage = $tokenAccessibleStorage;
        $this->urlGenerator           = $urlGenerator;
        $this->frontRootUrl           = rtrim($frontRootUrl, '/');
    }

    /**
     * Создаёт и возвращает адрес для скачивания файла на основе переданных мета-данных
     *
     * @param MetadataInterface $metadata
     * @param int               $ttl
     *
     * @return string
     */
    public function generateUrl(MetadataInterface $metadata, int $ttl = 0): string
    {
        $token = $this->tokenAccessibleStorage->generateToken($metadata, $ttl);

        $url = $this->frontRootUrl;

        $url .= $this->urlGenerator->generate(
            'file.download',
            ['token' => $token],
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        return $url;
    }
}
