<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Cognitive\Jwt\Token\TokenFactoryInterface;
use Cognitive\Timer\Timer;
use League\Flysystem\FilesystemInterface;
use Order\File\Embeddable\MetadataInterface;
use Order\File\Exception\OperationFailedException;
use Order\File\Exception\UrlExpiredException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Сервис предоставление доступа к файлам через jwt токен
 */
class JwtAccessibleStorage implements TokenAccessibleStorageInterface
{
    /**
     * Файловая система
     *
     * @var FilesystemInterface
     */
    private $filesystem;

    /**
     * Таймер
     *
     * @var Timer
     */
    private $timer;

    /**
     * Сервис токенов
     *
     * @var TokenServiceInterface
     */
    private $tokenService;

    /**
     * Фабрика ключей доступа
     *
     * @var TokenFactoryInterface
     */
    private $tokenFactory;

    /**
     * Директория с временными файлами
     *
     * @var string
     */
    private $tmpFileDir;

    /**
     * Конструктор
     *
     * @param FilesystemInterface   $filesystem
     * @param Timer                 $timer
     * @param TokenFactoryInterface $tokenFactory
     * @param TokenServiceInterface $tokenService
     * @param string                $tmpFileDir
     */
    public function __construct(
        FilesystemInterface $filesystem,
        Timer $timer,
        TokenFactoryInterface $tokenFactory,
        TokenServiceInterface $tokenService,
        string $tmpFileDir
    ) {
        $this->filesystem   = $filesystem;
        $this->timer        = $timer;
        $this->tokenFactory = $tokenFactory;
        $this->tokenService = $tokenService;
        $this->tmpFileDir   = rtrim($tmpFileDir, '/').'/';
    }

    /**
     * Создает ссылку на скачивание файла
     *
     * @param MetadataInterface $metadata
     * @param int               $ttl
     *
     * @return string
     *
     * @throws OperationFailedException
     */
    public function generateToken(MetadataInterface $metadata, int $ttl = 0): string
    {
        $fullPath = $metadata->getPath();
        if (!$this->filesystem->has($fullPath)) {
            throw new OperationFailedException();
        }

        $timestamp = 0;

        if ($ttl) {
            $timestamp = $this->timer->getTime()->getTimestamp() + $ttl;
        }

        return $this->tokenService->createToken(
            $metadata->getName(),
            $fullPath,
            $timestamp
        );
    }

    /**
     * Вовзращает файл по jwt ключу
     *
     * @param string $token
     *
     * @return File
     *
     * @throws OperationFailedException
     * @throws UrlExpiredException
     */
    public function getFile(string $token): File
    {
        $token = $this->tokenFactory->createToken($token);

        if (null === $token) {
            throw new OperationFailedException();
        }

        if ($token->isExpired()) {
            throw new UrlExpiredException();
        }

        $name = $token->getClaim('name');
        $path = $token->getClaim('path');

        $contents = $this->filesystem->read($path);

        if ($contents === false) {
            throw new OperationFailedException();
        }

        $filePath = $this->tmpFileDir.uniqid('tmp', true).$name;
        if (!file_put_contents($filePath, $contents, LOCK_EX)) {
            throw new OperationFailedException();
        }

        return new File($filePath);
    }
}
