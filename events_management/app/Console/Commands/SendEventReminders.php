<?php

namespace App\Console\Commands;

use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send nofifications to all attendees of upcoming events.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
            ->whereBetween('start_time', [now(), now()->addDays(2)])
            ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $this->info('Found ' . $eventCount . ' upcoming ' . $eventLabel . '.');

        $events->each(
            fn($event) => $event->attendees->each(
                fn($attendee) => $this->info("Send reminder to " . $attendee->user->id . " for event " . $event->name)
            )
        );

        $this->info('Send event reminders successfully.');
    }
}
