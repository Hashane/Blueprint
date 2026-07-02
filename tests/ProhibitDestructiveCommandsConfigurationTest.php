<?php

declare(strict_types=1);

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Judehashane\Blueprint\Configurations\ProhibitDestructiveCommandsConfiguration;

it('is enabled in production when the config flag is on', function (): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(true);

    $config = Mockery::mock(Repository::class);
    $config->shouldReceive('get')->with('blueprint.prohibit_destructive_commands', true)->andReturn(true);

    $configuration = new ProhibitDestructiveCommandsConfiguration($app, $config);

    expect($configuration->enabled())->toBeTrue();
});

it('is disabled outside production', function (): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(false);

    $config = Mockery::mock(Repository::class);

    $configuration = new ProhibitDestructiveCommandsConfiguration($app, $config);

    expect($configuration->enabled())->toBeFalse();
});

it('is disabled in production when the config flag is off', function (): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(true);

    $config = Mockery::mock(Repository::class);
    $config->shouldReceive('get')->with('blueprint.prohibit_destructive_commands', true)->andReturn(false);

    $configuration = new ProhibitDestructiveCommandsConfiguration($app, $config);

    expect($configuration->enabled())->toBeFalse();
});
