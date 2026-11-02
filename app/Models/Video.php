<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * An embedded video. Only YouTube, Vimeo and Facebook links are accepted
 * (see URL_PATTERN); the page embeds them through $video->embed_url.
 */
#[Fillable(['title', 'url', 'event_id', 'sort_order', 'is_published'])]
class Video extends Model
{
    use Publishable;

    /**
     * Accepted video links: YouTube, Vimeo or Facebook.
     */
    public const string URL_PATTERN = '~^https?://(www\.|m\.)?(youtube\.com|youtu\.be|vimeo\.com|player\.vimeo\.com|facebook\.com|fb\.watch)/~i';

    private const string YOUTUBE_ID = '~(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([\w-]{6,})~';

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * The YouTube video id, or null for other providers.
     */
    public function youtubeId(): ?string
    {
        return preg_match(self::YOUTUBE_ID, (string) $this->url, $matches) ? $matches[1] : null;
    }

    /**
     * Player URL for an iframe: YouTube (privacy-enhanced), Vimeo or
     * Facebook; null when the link is not one of these.
     *
     * @return Attribute<?string, never>
     */
    protected function embedUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            $url = (string) $this->url;

            if ($id = $this->youtubeId()) {
                return 'https://www.youtube-nocookie.com/embed/'.$id;
            }

            if (preg_match('~vimeo\.com/(?:video/)?(\d+)~', $url, $matches)) {
                return 'https://player.vimeo.com/video/'.$matches[1];
            }

            if (preg_match('~^https?://(www\.|m\.)?(facebook\.com|fb\.watch)/~i', $url)) {
                return 'https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=false';
            }

            return null;
        });
    }

    /**
     * YouTube thumbnail; null for other providers.
     *
     * @return Attribute<?string, never>
     */
    protected function thumbnailUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => ($id = $this->youtubeId()) ? 'https://i.ytimg.com/vi/'.$id.'/hqdefault.jpg' : null);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }
}
