<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Order\File\Embeddable\MetadataInterface;

/**
 * Интерфейс сервиса создания адресов для скачивания файлов
 */
interface DownloadUrlGeneratorInterface
{
    /**
     * Создаёт и возвращает адрес для скачивания файла на основе переданных мета-данных
     *
     * @param MetadataInterface $metadata
     * @param int               $ttl
     *
     * @return string
     */
    public function generateUrl(MetadataInterface $metadata, int $ttl = 0): string;
}
