<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Str;

final readonly class UserObserver
{
    /**
     * {@inheritdoc}
     */
    public function creating(User $user): void {

        $user->referral_code = Str::upper(Str::random(15));

    }

    /**
     * {@inheritdoc}
     */
    public function created(User $user): void
    {
    }

    /**
     * {@inheritdoc }
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * {@inheritdoc }
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * {@inheritdoc }
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * {@inheritdoc }
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
