<?php

namespace App\Component\Common\Infrastructure\Http\Middleware\Application;

use Closure;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SetRequestIdHeaderIfMissing
{
    private string $requestIdField;

    public function __construct(Config $config)
    {
        $this->requestIdField = (string) $config->get('logging.request_id.header');
    }

    /** @param Request|mixed $request */
    public function handle(
        $request,
        Closure $next,
    )
    {
        $requestId = (string) $request->header($this->requestIdField);

        if ($requestId === '') {
            $requestId = (string) Str::uuid();
        }

        $request->headers->set($this->requestIdField, $requestId);
        $response = $next($request);

        if ($response instanceof Response) {
            $response->headers->set($this->requestIdField, $requestId);
        }

        return $response;
    }
}
