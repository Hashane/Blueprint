<?php

declare(strict_types=1);

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Vite;
use Judehashane\Seatbelt\Configurations\ViteAggressivePrefetching;

it('switches the resolved Vite instance to the aggressive prefetching strategy', function (): void {
    $app = Mockery::mock(Application::class);
    $config = Mockery::mock(Repository::class);

    (new ViteAggressivePrefetching($app, $config))->apply();

    $prefetchStrategy = (new ReflectionProperty(Vite::class, 'prefetchStrategy'))
        ->getValue(app(Vite::class));

    expect($prefetchStrategy)->toBe('aggressive');
});
