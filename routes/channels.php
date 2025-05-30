<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('presence.users', function ($user) {
    if ($user) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->roles()->first() ? $user->roles()->first()->name : null,
        ];
    }
});

Broadcast::channel('admin.notifications', function ($user) {
    return $user->isAdmin();
});
