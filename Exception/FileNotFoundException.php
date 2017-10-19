<?php

declare(strict_types = 1);

namespace Order\File\Exception;

use Exception;

/**
 * Файл не найден
 */
class FileNotFoundException extends Exception
{
    /**
     * Конструктор
     *
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct(sprintf('File %s not found', $fileName));
    }
}
