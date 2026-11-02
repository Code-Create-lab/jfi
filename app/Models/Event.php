<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title', 'slug', 'summary', 'description', 'venue', 'city', 'state',
    'start_date', 'end_date', 'cover_image', 'is_featured', 'is_published',
])]
class Event extends Model
{
    use DeletesStoredFiles, HasSlug, Publishable;

    protected static function booted(): void
    {
        // Through the models (not only the FK cascade) so result photos are deleted too.
        static::deleting(function (Event $event): void {
            $event->results()->get()->each->delete();
        });
    }

    /**
     * @return HasMany<EventResult, $this>
     */
    public function results(): HasMany
    {
        return $this->hasMany(EventResult::class);
    }

    /**
     * @return HasMany<Gallery, $this>
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * @return HasMany<Video, $this>
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * @return HasMany<Certificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Human-readable date range, e.g. "15–17 Jan 2027" or "28 Feb – 2 Mar 2027".
     */
    public function dateRange(): string
    {
        $start = $this->start_date;
        $end = $this->end_date;

        if ($end === null || $end->isSameDay($start)) {
            return $start->format('j M Y');
        }

        if ($start->isSameMonth($end)) {
            return $start->format('j').'–'.$end->format('j M Y');
        }

        if ($start->isSameYear($end)) {
            return $start->format('j M').' – '.$end->format('j M Y');
        }

        return $start->format('j M Y').' – '.$end->format('j M Y');
    }

    /**
     * Where the event sits relative to today: "upcoming", "current" or "previous".
     */
    public function period(): string
    {
        $lastDay = $this->end_date ?? $this->start_date;

        return match (true) {
            $this->start_date->isAfter(today()) => 'upcoming',
            $lastDay->isBefore(today()) => 'previous',
            default => 'current',
        };
    }

    /**
     * Events that start after today.
     */
    #[Scope]
    protected function upcoming(Builder $query): void
    {
        $query->where($this->qualifyColumn('start_date'), '>', today());
    }

    /**
     * Events running today. A null end_date means a single-day event.
     */
    #[Scope]
    protected function current(Builder $query): void
    {
        $query->where($this->qualifyColumn('start_date'), '<=', today())
            ->whereRaw($this->lastDayExpression().' >= ?', [today()]);
    }

    /**
     * Current and upcoming events: the last day is today or later.
     */
    #[Scope]
    protected function notFinished(Builder $query): void
    {
        $query->whereRaw($this->lastDayExpression().' >= ?', [today()]);
    }

    /**
     * Events whose last day is before today.
     */
    #[Scope]
    protected function previous(Builder $query): void
    {
        $query->whereRaw($this->lastDayExpression().' < ?', [today()]);
    }

    /**
     * @return array<string, string>
     */
    protected function storedFiles(): array
    {
        return ['cover_image' => 'public'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    /**
     * SQL for the event's last day, treating a null end_date as start_date.
     */
    private function lastDayExpression(): string
    {
        return 'coalesce('.$this->qualifyColumn('end_date').', '.$this->qualifyColumn('start_date').')';
    }
}
