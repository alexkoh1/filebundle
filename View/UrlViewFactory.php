<?php

declare(strict_types = 1);

namespace Order\File\View;

use Cognitive\View\ViewFactoryInterface;

/**
 * Фабрика представления URL для скачивания файла
 */
class UrlViewFactory implements ViewFactoryInterface
{
    /**
     * Создаёт представление
     *
     * @param string $name
     * @param string $context
     *
     * @return mixed
     */
    public function createView(string $name, $context = null)
    {
        return ['url' => $context];
    }
}
