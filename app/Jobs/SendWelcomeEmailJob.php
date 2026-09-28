<?php

namespace App\Jobs;

use App\Models\User;
use App\Mail\WelcomeUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $user; //QUE VA A RECORDAR EL JOB

    public function __construct(User $user) //RECIVE LOS DATOS CUANDO LOS DESPACHA 
    {
        $this->user = $user;
    }

    public function handle(): void //
    {
        Mail::to($this->user->email)->send(new WelcomeUserMail([
            'name' => $this->user->name,
        ]));
    }
}