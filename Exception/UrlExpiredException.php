<?php

declare(strict_types = 1);

namespace Order\File\Exception;

use Exception;

/**
 * Файл не найден
 */
class UrlExpiredException extends Exception
{
    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct('Url expired');
    }
}
