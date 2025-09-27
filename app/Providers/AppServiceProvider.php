<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Auth\Notifications\ResetPassword;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Aqui SIM existe:
        $this->registerPolicies();

        // Configurações do Passport
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // Link de redefinição apontando para o front (Angular)
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
        $front = env('FRONTEND_URL', 'http://localhost:4200/reset-password');
        return $front.'?token='.$token.'&email='.urlencode($user->email);
    });
    }
}
