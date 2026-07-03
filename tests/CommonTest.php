<?php

declare(strict_types=1);

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Judehashane\Blueprint\Configurations\AutomaticEagerLoading;
use Judehashane\Blueprint\Configurations\DefaultPasswordRules;
use Judehashane\Blueprint\Configurations\ForceHttpsScheme;
use Judehashane\Blueprint\Configurations\ProhibitDestructiveCommands;

dataset('production-gated configurations', [
    'ProhibitDestructiveCommands' => [ProhibitDestructiveCommands::class, 'blueprint.prohibit_destructive_commands'],
    'DefaultPasswordRules' => [DefaultPasswordRules::class, 'blueprint.password.enforce_rule'],
    'ForceHttpsScheme' => [ForceHttpsScheme::class, 'blueprint.force_https_scheme'],
    'AutomaticEagerLoading' => [AutomaticEagerLoading::class, 'blueprint.automatically_eager_load_relationships'],
]);

it('is enabled in production when its config flag is on', function (string $class, string $key): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(true);

    $config = Mockery::mock(Repository::class);
    $config->shouldReceive('get')->with($key, true)->andReturn(true);

    expect((new $class($app, $config))->enabled())->toBeTrue();
})->with('production-gated configurations');

it('is disabled outside production', function (string $class, string $key): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(false);

    $config = Mockery::mock(Repository::class);

    expect((new $class($app, $config))->enabled())->toBeFalse();
})->with('production-gated configurations');

it('is disabled in production when its config flag is off', function (string $class, string $key): void {
    $app = Mockery::mock(Application::class);
    $app->shouldReceive('isProduction')->andReturn(true);

    $config = Mockery::mock(Repository::class);
    $config->shouldReceive('get')->with($key, true)->andReturn(false);

    expect((new $class($app, $config))->enabled())->toBeFalse();
})->with('production-gated configurations');
