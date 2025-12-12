<?php

namespace App\Observers;

use App\Models\Event;
use Illuminate\Support\Facades\Log;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        Log::info("Нов настан е креиран: {$event->name} (ID: {$event->id})");
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
        Log::info("Настанот е ажуриран: {$event->name} (ID: {$event->id})");
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        Log::info("Настанот е откажан: {$event->full_name} (ID: {$event->id})");
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
