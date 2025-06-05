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
    
    // Jumlah percobaan maksimal
    public $tries = 3;
    
    // Waktu tunggu antar percobaan (dalam detik)
    public $backoff = [10, 30, 60];
    
    // Timeout job (dalam detik)
    public $timeout = 60;
    
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
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email ke ' . $this->email . ': ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            throw $e; // Melempar kembali exception agar job retry berjalan
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