<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Vonage\Client;
use Vonage\Client\Credentials\Keypair;

class OpenTokProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {        
        $this->app->singleton(Client::class, function ($app) {
            // Define the path to your private key and application ID
            $privateKeyPath = storage_path('app/private.key');
            $privateKeyContent = file_get_contents($privateKeyPath);

            // Ensure the application ID is set in your .env file
            $applicationId = env('VONAGE_APPLICATION_ID');

            // Create Vonage credentials using the Keypair
            $credentials = new Keypair($privateKeyContent, $applicationId);

            // Return a new instance of the Vonage Client
            return new Client($credentials);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
