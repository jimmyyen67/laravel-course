<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Use Policy to authorize the actions
        // Gate::define('update-event', function($user, Event $event) {
        //     return $user->id === $event->user_id;
        // });
        //
        // // Event Creator can delete other attendee, or the attendees can delete themselves
        // Gate::define('delete-attendee', function($user, Event $event, Attendee $attendee) {
        //     return $user->id === $event->user_id || $user->id === $attendee->user_id;
        // });
    }
}
