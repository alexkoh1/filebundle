<?php

declare(strict_types = 1);

namespace Order\File\Embeddable;

/**
 * Метаданные файла
 */
class Metadata implements MetadataInterface
{
    /**
     * Размер
     *
     * @var int
     */
    private $size = 0;

    /**
     * MIME-тип
     *
     * @var string
     */
    private $mime = '';

    /**
     * Имя файла
     *
     * @var string
     */
    private $name = '';

    /**
     * Путь к файлу
     *
     * @var string
     */
    private $path = '';

    /**
     * Возвращает размер
     *
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * Устанавливает размер
     *
     * @param int $size
     */
    public function setSize(int $size)
    {
        $this->size = $size;
    }

    /**
     * Возвращает MIME-тип
     *
     * @return string
     */
    public function getMime(): string
    {
        return $this->mime;
    }

    /**
     * Устанавливает MIME-тип
     *
     * @param string $mime
     */
    public function setMime(string $mime)
    {
        $this->mime = $mime;
    }

    /**
     * Возвращает имя файла
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Устанавливает имя файла
     *
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Возвращает путь к файлу
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Устанавливает путь к файлу
     *
     * @param string $path
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }
}
