<?php

declare(strict_types=1);

namespace Judehashane\Blueprint\Configurations;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rules\Password;
use Judehashane\Blueprint\Contracts\Configuration;

final class DefaultPasswordRules implements Configuration
{
    public function __construct(
        private readonly Application $app,
        private readonly Repository $config,
    ) {}

    public function enabled(): bool
    {
        return $this->app->isProduction()
            && $this->config->get('blueprint.password.enforce_rule', true);
    }

    public function apply(): void
    {
        Password::defaults(function (): Password {
            $minLength = $this->config->get('blueprint.password.min_length', 12);
            $maxLength = $this->config->get('blueprint.password.max_length', 255);

            $rule = Password::min(is_int($minLength) ? $minLength : 12)->max(is_int($maxLength) ? $maxLength : 255);

            if ($this->config->get('blueprint.password.require_letter', true)) {
                $rule = $rule->letters();
            }

            if ($this->config->get('blueprint.password.require_numbers', true)) {
                $rule = $rule->numbers();
            }

            if ($this->config->get('blueprint.password.require_symbols', true)) {
                $rule = $rule->symbols();
            }

            return $rule->uncompromised();
        });
    }
}
