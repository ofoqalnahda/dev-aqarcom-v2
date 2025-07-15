<?php

namespace App\Libraries\Base\Http;

use App\Libraries\Support\UploadedFileHelper;
use BadMethodCallException;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

abstract class Handler extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @param  string  $method
     * @param  array  $parameters
     * @return Response|array
     */
    public function callAction(
        $method,
        $parameters,
    )
    {
        if ($method !== '__invoke') {
            throw new BadMethodCallException('Only __invoke method can be called on handler.');
        }

        return $this->{$method}(...array_values($parameters));
    }

    /**
     * @todo: Remove retrieveFile() method and replace it with UploadedFileHelper class
     * @throws Exception
     */
    protected function retrieveFile(string $filePath): File
    {

        return UploadedFileHelper::retrieveFile($filePath);
    }

    /** @todo: Remove retrieveUploadFile() method and replace it with UploadedFileHelper class */
    protected function retrieveUploadFile(
        ?string $filePath,
        ?string $fileName = null,
    ): ?UploadedFile
    {
        return UploadedFileHelper::retrieveUploadedFile($filePath, $fileName);
    }
}
