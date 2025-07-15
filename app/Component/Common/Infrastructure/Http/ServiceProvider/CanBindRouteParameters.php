<?php

namespace App\Component\Common\Infrastructure\Http\ServiceProvider;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait CanBindRouteParameters
{
    protected function bindRouteParameter(
        string $routeParameterName,
        string $entityClass,
        string $exceptionClass,
    ): void
    {
        Route::bind($routeParameterName, function (string $uuid) use ($entityClass, $exceptionClass) {
            $exists = $entityClass::query()
                ->where('uuid', '=', $uuid)
                ->exists();

            if (!$exists) {
                $entityName = Str::afterLast($entityClass, '\\');

                throw new $exceptionClass("{$entityName} with UUID {$uuid} not found", Response::HTTP_NOT_FOUND);
            }

            return $uuid;
        });
    }
}
