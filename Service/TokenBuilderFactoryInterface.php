<?php

declare(strict_types = 1);

namespace Order\File\Service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Claim\Factory as ClaimFactory;
use Lcobucci\JWT\Parsing\Encoder;

/**
 * Интерфейс фабрики строителей токенов
 */
interface TokenBuilderFactoryInterface
{
    /**
     * Создает строителя
     *
     * @param Encoder|null      $encoder
     * @param ClaimFactory|null $claimFactory
     *
     * @return Builder
     */
    public function createBuilder(
        Encoder $encoder = null,
        ClaimFactory $claimFactory = null
    ): Builder;
}
