<?php

namespace Tests\Feature\Admin;

use App\Filament\Resources\CommunityCategories\Pages\EditCommunityCategory;
use App\Filament\Resources\CommunityCategories\RelationManagers\PostsRelationManager;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\ContactMessages\Pages\ListContactMessages;
use App\Filament\Resources\ContactMessages\Pages\ViewContactMessage;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\RelationManagers\ImagesRelationManager;
use App\Filament\Resources\InternationalPlayers\Pages\ListInternationalPlayers;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Models\CommunityCategory;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\InternationalPlayer;
use App\Models\User;
use App\Models\Video;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MediaCommunityUsersTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        $this->actingAs($this->admin);
        Storage::fake('public');
    }

    public function test_upload_photos_creates_one_image_per_file_in_order(): void
    {
        $gallery = Gallery::query()->create(['title' => 'Junior Nationals']);
        $gallery->images()->create(['image' => 'gallery/existing.jpg', 'sort_order' => 5]);

        Livewire::test(ImagesRelationManager::class, ['ownerRecord' => $gallery, 'pageClass' => EditGallery::class])
            ->callAction(TestAction::make('upload')->table(), [
                'photos' => [
                    UploadedFile::fake()->image('a.jpg', 800, 600),
                    UploadedFile::fake()->image('b.jpg', 800, 600),
                ],
            ])
            ->assertHasNoActionErrors();

        $images = $gallery->images()->orderBy('sort_order')->get();
        $this->assertCount(3, $images);
        $this->assertSame([5, 6, 7], $images->pluck('sort_order')->all());
        Storage::disk('public')->assertExists($images->skip(1)->pluck('image')->all());
    }

    public function test_upload_is_limited_per_batch(): void
    {
        $gallery = Gallery::query()->create(['title' => 'Big album']);
        $photos = collect(range(1, ImagesRelationManager::MAX_PHOTOS_PER_BATCH + 1))
            ->map(fn (int $i) => UploadedFile::fake()->image("p{$i}.jpg", 100, 100))
            ->all();

        Livewire::test(ImagesRelationManager::class, ['ownerRecord' => $gallery, 'pageClass' => EditGallery::class])
            ->callAction(TestAction::make('upload')->table(), ['photos' => $photos])
            ->assertHasActionErrors(['photos']);

        $this->assertSame(0, $gallery->images()->count());
    }

    public function test_deleting_a_gallery_deletes_its_photo_files(): void
    {
        Storage::disk('public')->put('gallery/a.jpg', 'x');
        $gallery = Gallery::query()->create(['title' => 'Album']);
        $gallery->images()->create(['image' => 'gallery/a.jpg']);

        $gallery->delete();

        Storage::disk('public')->assertMissing('gallery/a.jpg');
        $this->assertDatabaseCount('gallery_images', 0);
    }

    public function test_video_links_must_be_youtube_vimeo_or_facebook(): void
    {
        Livewire::test(CreateVideo::class)
            ->fillForm(['title' => 'Final', 'url' => 'https://example.com/video.mp4'])
            ->call('create')
            ->assertHasFormErrors(['url']);

        Livewire::test(CreateVideo::class)
            ->fillForm(['title' => 'Final', 'url' => 'https://youtu.be/dQw4w9WgXcQ'])
            ->call('create')
            ->assertHasNoFormErrors();

        $video = Video::query()->firstOrFail();
        $this->assertSame('https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ', $video->embed_url);
        $this->assertSame('https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg', $video->thumbnail_url);

        $this->assertSame('https://player.vimeo.com/video/76979871', (new Video(['url' => 'https://vimeo.com/76979871']))->embed_url);
        $this->assertStringStartsWith('https://www.facebook.com/plugins/video.php?href=', (new Video(['url' => 'https://www.facebook.com/jfi/videos/123456/']))->embed_url);
        $this->assertNull((new Video(['url' => 'https://vimeo.com/76979871']))->thumbnail_url);
    }

    public function test_international_players_filter_by_country(): void
    {
        $nepal = InternationalPlayer::query()->create(['name' => 'Player One', 'country' => 'Nepal']);
        $bhutan = InternationalPlayer::query()->create(['name' => 'Player Two', 'country' => 'Bhutan']);

        Livewire::test(ListInternationalPlayers::class)
            ->assertCanSeeTableRecords([$nepal, $bhutan])
            ->filterTable('country', 'Nepal')
            ->assertCanSeeTableRecords([$nepal])
            ->assertCanNotSeeTableRecords([$bhutan]);
    }

    public function test_community_post_with_pdf_can_be_added_and_unpublished(): void
    {
        $category = CommunityCategory::query()->create(['name' => 'Player Safety']);

        Livewire::test(PostsRelationManager::class, ['ownerRecord' => $category, 'pageClass' => EditCommunityCategory::class])
            ->callAction(TestAction::make('create')->table(), [
                'title' => 'Safe Play Guidelines',
                'document_path' => [UploadedFile::fake()->create('guidelines.pdf', 200, 'application/pdf')],
            ])
            ->assertHasNoActionErrors();

        $post = $category->posts()->firstOrFail();
        Storage::disk('public')->assertExists($post->document_path);

        Livewire::test(PostsRelationManager::class, ['ownerRecord' => $category, 'pageClass' => EditCommunityCategory::class])
            ->call('updateTableColumnState', 'is_published', (string) $post->getKey(), false);

        $this->assertFalse($post->fresh()->is_published);

        $category->delete();
        Storage::disk('public')->assertMissing($post->document_path);
    }

    public function test_viewing_a_message_marks_it_read_and_unread_count_is_the_badge(): void
    {
        $first = ContactMessage::query()->create(['name' => 'A', 'email' => 'a@example.com', 'message' => 'Hello']);
        ContactMessage::query()->create(['name' => 'B', 'email' => 'b@example.com', 'message' => 'Hi']);

        $this->assertSame('2', ContactMessageResource::getNavigationBadge());

        Livewire::test(ViewContactMessage::class, ['record' => $first->getRouteKey()])->assertOk();

        $this->assertNotNull($first->fresh()->read_at);
        $this->assertSame('1', ContactMessageResource::getNavigationBadge());

        Livewire::test(ListContactMessages::class)
            ->filterTable('read', false)
            ->assertCanNotSeeTableRecords([$first]);

        $this->get('/admin/contact-messages/create')->assertNotFound();
        $this->get('/admin/contact-messages/'.$first->getKey().'/edit')->assertNotFound();
    }

    public function test_admin_users_can_be_created_and_cannot_delete_themselves(): void
    {
        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Second Admin', 'email' => 'second@example.com', 'password' => 'secret-password', 'password_confirmation' => 'other'])
            ->call('create')
            ->assertHasFormErrors(['password']);

        Livewire::test(CreateUser::class)
            ->fillForm(['name' => 'Second Admin', 'email' => 'second@example.com', 'password' => 'secret-password', 'password_confirmation' => 'secret-password'])
            ->call('create')
            ->assertHasNoFormErrors();

        $second = User::query()->where('email', 'second@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('secret-password', $second->password));

        Livewire::test(ListUsers::class)
            ->assertActionHidden(TestAction::make('delete')->table($this->admin))
            ->assertActionVisible(TestAction::make('delete')->table($second));

        Livewire::test(EditUser::class, ['record' => $this->admin->getRouteKey()])
            ->assertActionHidden('delete');

        $this->assertFalse($this->admin->can('delete', $this->admin));
        $this->assertTrue($this->admin->can('delete', $second));
    }

    public function test_profile_page_is_available(): void
    {
        $this->get('/admin/profile')->assertOk();
    }
}
