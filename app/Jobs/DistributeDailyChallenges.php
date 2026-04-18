<?php

namespace App\Jobs;

use App\Models\HealthChallenge;
use App\Models\User;
use App\Models\UserChallenge;
use App\Notifications\NewChallengeNotification;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DistributeDailyChallenges implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today      = Carbon::today();
        $challenges = HealthChallenge::where('active', true)->get();

        if ($challenges->isEmpty()) {
            return;
        }

        $users = User::where('role', 'pasien')->get();

        foreach ($users as $user) {
            // Pick up to 3 random challenges per day
            $daily = $challenges->random(min(3, $challenges->count()));

            foreach ($daily as $challenge) {
                $uc = UserChallenge::firstOrCreate(
                    [
                        'user_id'             => $user->id,
                        'health_challenge_id' => $challenge->id,
                        'challenge_date'      => $today,
                    ],
                    ['completed' => false]
                );

                // Notify on first creation only
                if ($uc->wasRecentlyCreated) {
                    $user->notify(new NewChallengeNotification($uc));
                }
            }
        }
    }
}

