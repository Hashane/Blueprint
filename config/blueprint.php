<?php

declare(strict_types=1);
use Judehashane\Blueprint\Configurations\ProhibitDestructiveCommandsConfiguration;

return [

    /*
    |--------------------------------------------------------------------------
    | Configurations
    |--------------------------------------------------------------------------
    |
    | Configuration classes to run on boot. Each must implement
    | Judehashane\Blueprint\Contracts\Configuration. A configuration only takes effect when
    | its own enabled() check passes.
    |
    */

    'configurations' => [
        ProhibitDestructiveCommandsConfiguration::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Prohibit Destructive Commands
    |--------------------------------------------------------------------------
    |
    | When true, ProhibitDestructiveCommandsConfiguration blocks db:wipe,
    | migrate:fresh, and migrate:reset while the app environment is
    | "production" — even if invoked with --force.
    |
    */

    'prohibit_destructive_commands' => env('BLUEPRINT_PROHIBIT_DESTRUCTIVE_COMMANDS', true),

];
