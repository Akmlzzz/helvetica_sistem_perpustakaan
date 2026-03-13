<?php

namespace App\Policies;

use App\Models\Pengguna;

class PenggunaPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(Pengguna $loggedInUser, Pengguna $targetUser): bool
    {
        // Admin bisa edit punyanya siapapun, anggota cuma bisa edit punya ID dia sendiri
        return $loggedInUser->isAdmin() || $loggedInUser->id_pengguna === $targetUser->id_pengguna;
    }
}
