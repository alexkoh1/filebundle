<?php

declare(strict_types = 1);

namespace Order\File\Exception;

use Exception;

/**
 * Операция не выполнена
 */
class OperationFailedException extends Exception
{
    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct('Operation failed');
    }
}
