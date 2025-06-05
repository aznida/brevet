<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Queue::failing(function (JobFailed $event) {
            // Kirim notifikasi ke admin jika job gagal
            if ($event->job->resolveName() === 'App\\Jobs\\SendParticipantNotification') {
                // Simpan ke database atau kirim notifikasi
                \Log::critical('Email job gagal: ' . $event->exception->getMessage());
            }
        });
    }
}
