<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Order\File\Embeddable\MetadataInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Интерфейс файлового хранилища
 */
interface StorageServiceInterface
{
    /**
     * Загружает файл
     *
     * @param UploadedFile $file
     *
     * @return MetadataInterface
     */
    public function upload(UploadedFile $file): MetadataInterface;

    /**
     * Копирует файл
     *
     * @param MetadataInterface $metadata
     *
     * @return MetadataInterface
     */
    public function copy(MetadataInterface $metadata): MetadataInterface;
}
