<?php

namespace App\Models;

use App\Enums\DownloadCategory;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'category', 'description', 'file_path', 'published_on', 'is_published'])]
class Download extends Model
{
    use Publishable;

    /**
     * Upper-case file extension for display, e.g. "PDF".
     */
    public function fileExtension(): string
    {
        return Str::upper(pathinfo($this->file_path, PATHINFO_EXTENSION)) ?: 'FILE';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => DownloadCategory::class,
            'published_on' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
