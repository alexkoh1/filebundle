<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key;
use League\OAuth2\Server\CryptKey;

/**
 * Строитель токенов
 */
class TokenService implements TokenServiceInterface
{
    /**
     * Фабрика строителей форм
     *
     * @var TokenBuilderFactoryInterface
     */
    private $factory;

    /**
     * Приватный ключ
     *
     * @var CryptKey
     */
    private $privateKey;

    /**
     * Сервис подписывания ключей доступа
     *
     * @var Signer
     */
    private $signer;

    /**
     * Конструктор
     *
     * @param TokenBuilderFactoryInterface $factory
     * @param CryptKey                     $privateKey
     * @param Signer                       $signer
     */
    public function __construct(
        TokenBuilderFactoryInterface $factory,
        CryptKey $privateKey,
        Signer $signer
    ) {
        $this->factory    = $factory;
        $this->privateKey = $privateKey;
        $this->signer     = $signer;
    }

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
    ): string {
        $builder = $this->factory->createBuilder();

        $builder->set('name', $name);
        $builder->set('path', $path);

        if ($expiration) {
            $builder->setExpiration($expiration);
        }

        $key = new Key($this->privateKey->getKeyPath(), $this->privateKey->getPassPhrase());

        $builder->sign($this->signer, $key);

        return (string) $builder->getToken();
    }
}
