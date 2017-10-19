<?php

declare(strict_types = 1);

namespace Order\File\Service;

/**
 * Интерфейс сервиса токенов
 */
interface TokenServiceInterface
{
    /**
     * Создает токен
     *
     * @param string $name
     * @param string $path
     * @param int    $expiration
     *
     * @return string
     */
    public function createToken(
        string $name,
        string $path,
        int $expiration = 0
    ): string;
}
