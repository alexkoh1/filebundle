<?php

declare(strict_types = 1);

namespace Order\File\Adapter;

use League\Flysystem\WebDAV\WebDAVAdapter as Adapter;

/**
 * Адаптер WebDav
 */
class WebDavAdapter extends Adapter
{
    /**
     * Возвращает наличие ресурса
     *
     * @param string $path
     *
     * @return bool
     */
    public function has($path)
    {
        if (!$response = $this->client->request('GET', $path)) {
            return false;
        }

        if (!isset($response['statusCode'])) {
            return false;
        }

        if ($response['statusCode'] !== 200) {
            return false;
        }

        return true;
    }
}
