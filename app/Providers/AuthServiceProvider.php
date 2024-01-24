<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $frontUrl = env('APP_URL');
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) use ($frontUrl) {

            return $frontUrl . "/auth/password-reset/?token=$token&email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
