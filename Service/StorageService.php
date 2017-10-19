<?php

declare(strict_types = 1);

namespace Order\File\Service;

use League\Flysystem\FilesystemInterface;
use Order\File\Embeddable\Metadata;
use Order\File\Embeddable\MetadataInterface;
use Order\File\Exception\FileNotFoundException;
use Order\File\Exception\OperationFailedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Хранилище в файловой системе Flysystem
 */
class StorageService implements StorageServiceInterface
{
    /**
     * Файловая система
     *
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Путь до директории на удалённом сервере где хранятся файлы начиная от корневой директории
     *
     * @var string
     */
    private $remoteMountPath;

    /**
     * Конструктор
     *
     * @param FilesystemInterface $filesystem
     * @param string              $remoteMountPath
     */
    public function __construct(
        FilesystemInterface $filesystem,
        string $remoteMountPath
    ) {
        $this->filesystem      = $filesystem;
        $this->remoteMountPath = rtrim($remoteMountPath, '/').'/';
    }

    /**
     * Загружает файл
     *
     * @param UploadedFile $file
     *
     * @return MetadataInterface
     *
     * @throws FileNotFoundException
     * @throws OperationFailedException
     */
    public function upload(UploadedFile $file): MetadataInterface
    {
        $fullPath = $file->getRealPath();
        $fileName = $file->getFilename();

        if (!$fullPath) {
            throw new FileNotFoundException($fullPath);
        }

        $contents = file_get_contents($fullPath);

        if (!$contents) {
            throw new OperationFailedException();
        }

        if (!$this->filesystem->put($this->remoteMountPath.$fileName, $contents)) {
            throw new OperationFailedException();
        }

        $metadata = new Metadata();
        $metadata->setName($file->getClientOriginalName());
        $metadata->setMime($file->getMimeType());
        $metadata->setPath($this->remoteMountPath.$fileName);
        $metadata->setSize($file->getSize());

        return $metadata;
    }

    /**
     * Копирует файл
     *
     * @param MetadataInterface $metadata
     *
     * @return MetadataInterface
     *
     * @throws OperationFailedException
     * @throws FileNotFoundException
     */
    public function copy(MetadataInterface $metadata): MetadataInterface
    {
        $fullPath      = $metadata->getPath();
        $fileExtension = pathinfo($fullPath, PATHINFO_EXTENSION);

        if (!$this->filesystem->has($fullPath)) {
            throw new FileNotFoundException($fullPath);
        }

        do {
            $uniqFileName         = uniqid().'.'.$fileExtension;
            $uniqFileNameWithPath = $this->remoteMountPath.$uniqFileName;
        } while ($this->filesystem->has($uniqFileNameWithPath));

        if ($this->filesystem->copy($fullPath, $uniqFileNameWithPath)) {
            throw new OperationFailedException();
        }

        $newMetadata = new Metadata();
        $newMetadata->setSize($metadata->getSize());
        $newMetadata->setPath($uniqFileNameWithPath);
        $newMetadata->setMime($metadata->getMime());
        $newMetadata->setName($uniqFileName);

        return $newMetadata;
    }
}
