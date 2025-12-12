<?php

namespace App\Observers;

use App\Models\Organizer;
use Illuminate\Support\Facades\Log;

class OrganizerObserver
{
    /**
     * Handle the Organizer "created" event.
     */
    public function created(Organizer $organizer): void
    {
        session()->flash('success', "Нов организатор е креиран: {$organizer->full_name}");
        Log::info("Нов организатор е креиран: {$organizer->full_name} (ID: {$organizer->id})");
    }

    /**
     * Handle the Organizer "updated" event.
     */
    public function updated(Organizer $organizer): void
    {
        Log::info("Организаторот е ажуриран: {$organizer->full_name} (ID: {$organizer->id})");
    }

    /**
     * Handle the Organizer "deleted" event.
     */
    public function deleted(Organizer $organizer): void
    {
        Log::info("Организаторот е избришан: {$organizer->full_name} (ID: {$organizer->id})");
    }

    /**
     * Handle the Organizer "restored" event.
     */
    public function restored(Organizer $organizer): void
    {
        //
    }

    /**
     * Handle the Organizer "force deleted" event.
     */
    public function forceDeleted(Organizer $organizer): void
    {
        //
    }
}
