<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\Http\Handler;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

abstract class BaseHandler extends Controller
{
    protected function successfulOkResponse(array $content): Response
    {
        return response($content, Response::HTTP_OK);
    }

    protected function successfulNoContentResponse(): Response
    {
        return response(null, Response::HTTP_NO_CONTENT);
    }

    protected function successfulCreatedResponse(
        string $primaryKey,
        string $keyName = 'uuid',
    ): Response
    {
        $content = [$keyName => $primaryKey];

        return response($content, Response::HTTP_CREATED);
    }

    protected function successfulCreatedResponseWithData(array $data = null): Response
    {
        return response($data, Response::HTTP_CREATED);
    }

    /** @deprecated Use successfulDownloadResponse() */
    protected function successfulAttachmentResponse(
        string $content,
        string $contentType,
        string $filename,
    ): Response
    {
        return response(
            content: $content,
            status : 200,
            headers: [
                'Content-Disposition' => "attachment; filename='{$filename}'",
                'Content-Type'        => $contentType,
            ],
        );
    }

    protected function successfulDownloadResponse(
        string $content,
        string $filename,
    ): BinaryFileResponse
    {
        return response()
            ->download(file: $content, name: $filename)
            ->deleteFileAfterSend();
    }

    protected function errorFromException(\Throwable $exception): Response
    {
        $code = $exception->getCode() >= 400
            ? $exception->getCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $content = ['message' => $exception->getMessage()];

        return response($content, $code);
    }

    protected function errorBadRequestResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_BAD_REQUEST);
    }

    protected function errorUnauthorizedResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_UNAUTHORIZED);
    }

    protected function errorForbiddenResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_FORBIDDEN);
    }

    protected function errorNotFoundResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_NOT_FOUND);
    }

    protected function errorConflictResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_CONFLICT);
    }

    protected function errorUnprocessableEntityResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function errorTooManyRequestsResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_TOO_MANY_REQUESTS);
    }

    protected function errorInternalServerErrorResponse(string $message): Response
    {
        $content = ['message' => $message];

        return response($content, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
