<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Journal;

class JournalPolicy
{
    public function viewAny(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function view(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function create(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function update(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }

    public function delete(User $user, Journal $journal): bool
    {
        return $user->id === $journal->user_id;
    }
}
