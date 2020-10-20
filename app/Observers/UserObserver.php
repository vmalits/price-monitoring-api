<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    public function creating(User $user): void
    {
        $user->password = Hash::make($user->password);
    }
}
