<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogUserActivity implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the user logged in event.
     */
    public function handleUserLoggedIn(UserLoggedIn $event): void
    {
        $user = $event->user;
        Log::info("User logged in: {$user->name} (ID: {$user->id})");
    }

    /**
     * Handle the user logged out event.
     */
    public function handleUserLoggedOut(UserLoggedOut $event): void
    {
        $user = $event->user;
        Log::info("User logged out: {$user->name} (ID: {$user->id})");
    }
}