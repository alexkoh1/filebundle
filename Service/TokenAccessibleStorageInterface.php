<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Order\File\Embeddable\MetadataInterface;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Интерфейс сервиса предоставление доступа в файлам через токен
 */
interface TokenAccessibleStorageInterface
{
    /**
     * Создает токен для получения файла
     *
     * @param MetadataInterface $metadata
     * @param int               $ttl
     *
     * @return string
     */
    public function generateToken(MetadataInterface $metadata, int $ttl = 0): string;

    /**
     * Получает файл по токену
     *
     * @param string $token
     *
     * @return File
     */
    public function getFile(string $token): File;
}
