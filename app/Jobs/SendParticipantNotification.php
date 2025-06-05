<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendParticipantNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $name;
    protected $nik;
    protected $password;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $name, $nik, $password)
    {
        $this->email = $email;
        $this->name = $name;
        $this->nik = $nik;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $attempts = 0;
        $maxAttempts = 3;
        $success = false;
        
        while (!$success && $attempts < $maxAttempts) {
            try {
                Mail::send('emails.participant_notification', [
                    'name' => $this->name,
                    'nik' => $this->nik,
                    'password' => $this->password,
                    'url' => 'https://brempi.com/',
                ], function($message) {
                    $message->to($this->email)
                            ->subject('🔔 Akses Aplikasi Brevetisasi MO DEFA')
                            ->priority(1)
                            ->from(config('mail.from.address'), config('mail.from.name'))
                            ->replyTo(config('mail.from.address'), config('mail.from.name'));
                });
                
                \Log::info('Email berhasil dikirim ke: ' . $this->email);
                $success = true;
            } catch (\Exception $e) {
                $attempts++;
                \Log::warning("Percobaan ke-{$attempts} gagal untuk {$this->email}: {$e->getMessage()}");
                
                if ($attempts < $maxAttempts) {
                    sleep(5 * $attempts); // Backoff strategy
                } else {
                    throw $e;
                }
            }
        }
    }
    
    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        \Log::error('Job pengiriman email gagal untuk: ' . $this->email . ' - ' . $exception->getMessage());
    }
}