<?php

declare(strict_types = 1);

namespace Order\File\Embeddable;

/**
 * Интерфейс метаданных файла
 */
interface MetadataInterface
{
    /**
     * Возвращает размер
     *
     * @return int
     */
    public function getSize(): int;

    /**
     * Возвращает MIME-тип
     *
     * @return string
     */
    public function getMime(): string;

    /**
     * Возвращает имя файла
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Возвращает путь к файлу
     *
     * @return string
     */
    public function getPath(): string;
}
