<?php

declare(strict_types = 1);

namespace Order\File\Controller;

use Lcobucci\JWT\Parser;
use Order\File\Exception\OperationFailedException;
use Order\File\Exception\UrlExpiredException;
use Order\File\Service\TokenAccessibleStorageInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Контроллер скачивания файлов
 */
class DownloadController
{
    /**
     * Файловый сервис
     *
     * @var TokenAccessibleStorageInterface
     */
    private $tokenAccessibleStorage;

    /**
     * Конструктор
     *
     * @param TokenAccessibleStorageInterface $tokenAccessibleStorage
     */
    public function __construct(TokenAccessibleStorageInterface $tokenAccessibleStorage)
    {
        $this->tokenAccessibleStorage = $tokenAccessibleStorage;
    }

    /**
     * Выполняет действие
     *
     * @param Request $request
     *
     * @return BinaryFileResponse
     *
     * @throws BadRequestHttpException
     */
    public function execute(Request $request): BinaryFileResponse
    {
        try {
            $jwt  = $request->get('token');
            $file = $this->tokenAccessibleStorage->getFile($jwt);
        } catch (OperationFailedException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        } catch (UrlExpiredException $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }

        $response = new BinaryFileResponse($file->getPath().'/'.$file->getFilename());
        $response->deleteFileAfterSend(true);

        $parser = new Parser();
        $token  = $parser->parse($jwt);
        $response->setContentDisposition('attachment', $token->getClaim('name'));

        return $response;
    }
}
