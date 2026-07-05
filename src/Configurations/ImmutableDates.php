<?php

declare(strict_types=1);

namespace Judehashane\Blueprint\Configurations;

use Carbon\CarbonImmutable;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Facades\Date;
use Judehashane\Blueprint\Contracts\Configuration;

final class ImmutableDates implements Configuration
{
    public function __construct(
        private readonly Repository $config,
    ) {}

    public function enabled(): bool
    {
        return (bool) $this->config->get('blueprint.immutable_dates', true);
    }

    public function apply(): void
    {
        Date::use(CarbonImmutable::class);
    }
}
