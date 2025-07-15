<?php

declare(strict_types = 1);

namespace App\Component\Common\Infrastructure\ServiceProvider;

use Illuminate\Support\AggregateServiceProvider;

abstract class ServiceProvider extends AggregateServiceProvider
{
    public function register(): void
    {
        parent::register();
        $testingBindings = $this->app->runningUnitTests()
            ? $this->testingBindings()
            : [];
        $bindings = array_replace($this->regularBindings(), $testingBindings);

        foreach ($bindings as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }

    /** @return mixed[] */
    protected function regularBindings(): array
    {
        return [];
    }

    /** @return mixed[] */
    protected function testingBindings(): array
    {
        return [];
    }
}
