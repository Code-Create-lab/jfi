<?php

namespace Tests\Feature\Admin;

use App\Enums\DownloadCategory;
use App\Enums\NewsType;
use App\Enums\RegistrationStatus;
use App\Filament\Pages\SiteSettings;
use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Filament\Resources\Downloads\Pages\CreateDownload;
use App\Filament\Resources\Downloads\Pages\EditDownload;
use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\RelationManagers\ResultsRelationManager;
use App\Filament\Resources\News\Pages\CreateNews;
use App\Filament\Resources\News\Pages\ListNews;
use App\Filament\Resources\Pages\Pages\EditPage;
use App\Filament\Resources\Pages\Pages\ListPages;
use App\Models\Banner;
use App\Models\Download;
use App\Models\Event;
use App\Models\EventResult;
use App\Models\News;
use App\Models\Page;
use App\Models\Setting;
use App\Models\StateAssociation;
use App\Models\User;
use Database\Seeders\PageSeeder;
use Database\Seeders\SettingSeeder;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ContentModulesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
        Storage::fake('public');
    }

    public function test_event_can_be_created_with_a_cover_and_rejects_an_end_date_before_the_start(): void
    {
        Livewire::test(CreateEvent::class)
            ->fillForm(['title' => 'Nationals', 'start_date' => '2027-01-10', 'end_date' => '2027-01-05'])
            ->call('create')
            ->assertHasFormErrors(['end_date']);

        Livewire::test(CreateEvent::class)
            ->fillForm([
                'title' => 'Senior Nationals',
                'start_date' => '2027-01-10',
                'end_date' => '2027-01-12',
                'state' => 'Delhi',
                'cover_image' => UploadedFile::fake()->image('cover.jpg', 1200, 800),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $event = Event::query()->where('title', 'Senior Nationals')->firstOrFail();
        $this->assertSame('senior-nationals', $event->slug);
        Storage::disk('public')->assertExists($event->cover_image);
    }

    public function test_event_list_filters_by_period_using_the_scopes(): void
    {
        $upcoming = Event::query()->create(['title' => 'Upcoming Cup', 'start_date' => today()->addMonth()]);
        $current = Event::query()->create(['title' => 'Current Cup', 'start_date' => today()->subDay(), 'end_date' => today()->addDay()]);
        $previous = Event::query()->create(['title' => 'Previous Cup', 'start_date' => today()->subMonth()]);

        Livewire::test(ListEvents::class)
            ->assertCanSeeTableRecords([$upcoming, $current, $previous])
            ->filterTable('period', 'upcoming')
            ->assertCanSeeTableRecords([$upcoming])
            ->assertCanNotSeeTableRecords([$current, $previous])
            ->filterTable('period', 'current')
            ->assertCanSeeTableRecords([$current])
            ->assertCanNotSeeTableRecords([$upcoming, $previous]);
    }

    public function test_results_offer_approved_associations_only_and_are_sorted(): void
    {
        $event = Event::query()->create(['title' => 'Junior Nationals', 'start_date' => today()->subMonth()]);
        $approved = $this->association('Maharashtra Jumpball Association', RegistrationStatus::Approved);
        $pending = $this->association('Goa Jumpball Association', RegistrationStatus::Pending);

        $component = fn () => Livewire::test(ResultsRelationManager::class, ['ownerRecord' => $event, 'pageClass' => EditEvent::class]);

        $component()->callAction(TestAction::make('create')->table(), [
            'category' => 'Junior Boys', 'position' => 1, 'participant_name' => 'Goa', 'state_association_id' => $pending->id,
        ])->assertHasActionErrors(['state_association_id']);

        $component()->callAction(TestAction::make('create')->table(), [
            'category' => 'Junior Boys', 'position' => 2, 'participant_name' => 'Delhi',
        ])->assertHasNoActionErrors();

        $component()->callAction(TestAction::make('create')->table(), [
            'category' => 'Junior Boys', 'position' => 1, 'participant_name' => 'Maharashtra', 'state_association_id' => $approved->id,
        ])->assertHasNoActionErrors();

        $this->assertSame(['Maharashtra', 'Delhi'], $event->results()->orderBy('category')->orderBy('position')->pluck('participant_name')->all());

        $component()->assertCanSeeTableRecords($event->results()->orderBy('position')->get(), inOrder: true);
    }

    public function test_position_labels(): void
    {
        $labels = collect([1, 2, 3, 4, 11, 21, 22])->map(fn (int $position): string => (new EventResult(['position' => $position]))->positionLabel());

        $this->assertSame(['Winner', 'Runner-up', 'Third place', '4th', '11th', '21st', '22nd'], $labels->all());
    }

    public function test_deleting_an_event_deletes_its_results_and_their_photos(): void
    {
        Storage::disk('public')->put('events/cover.jpg', 'x');
        Storage::disk('public')->put('results/team.jpg', 'x');

        $event = Event::query()->create(['title' => 'Nationals', 'start_date' => today(), 'cover_image' => 'events/cover.jpg']);
        $result = $event->results()->create(['position' => 1, 'participant_name' => 'Kerala', 'photo' => 'results/team.jpg']);

        Livewire::test(EditEvent::class, ['record' => $event->getRouteKey()])->callAction('delete');

        $this->assertModelMissing($result);
        Storage::disk('public')->assertMissing(['events/cover.jpg', 'results/team.jpg']);
    }

    public function test_news_defaults_to_today_and_filters_by_type(): void
    {
        Livewire::test(CreateNews::class)
            ->assertSchemaStateSet(['published_on' => today()->toDateString(), 'type' => NewsType::News])
            ->fillForm(['title' => 'Calendar announced', 'type' => NewsType::Announcement->value])
            ->call('create')
            ->assertHasNoFormErrors();

        $announcement = News::query()->firstOrFail();
        $pressRelease = News::query()->create(['title' => 'Press note', 'type' => NewsType::PressRelease, 'published_on' => today()]);

        $this->assertTrue($announcement->published_on->isToday());

        Livewire::test(ListNews::class)
            ->filterTable('type', NewsType::Announcement->value)
            ->assertCanSeeTableRecords([$announcement])
            ->assertCanNotSeeTableRecords([$pressRelease]);
    }

    public function test_download_accepts_documents_and_replacing_the_file_deletes_the_old_one(): void
    {
        Livewire::test(CreateDownload::class)
            ->fillForm([
                'title' => 'Entry form',
                'category' => DownloadCategory::Form->value,
                'file_path' => UploadedFile::fake()->create('entry.exe', 10, 'application/x-msdownload'),
            ])
            ->call('create')
            ->assertHasFormErrors(['file_path']);

        Livewire::test(CreateDownload::class)
            ->fillForm([
                'title' => 'Entry form',
                'category' => DownloadCategory::Form->value,
                'file_path' => UploadedFile::fake()->create('entry.docx', 50, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $download = Download::query()->firstOrFail();
        $oldPath = $download->file_path;
        Storage::disk('public')->assertExists($oldPath);

        Livewire::test(EditDownload::class, ['record' => $download->getRouteKey()])
            ->fillForm(['file_path' => [UploadedFile::fake()->create('entry-v2.pdf', 50, 'application/pdf')]])
            ->call('save')
            ->assertHasNoFormErrors();

        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($download->fresh()->file_path);
    }

    public function test_banner_requires_an_image_and_lists_by_sort_order(): void
    {
        Livewire::test(CreateBanner::class)
            ->fillForm(['title' => 'Welcome'])
            ->call('create')
            ->assertHasFormErrors(['image' => 'required']);

        $second = Banner::query()->create(['title' => 'Second', 'image' => 'banners/b.jpg', 'sort_order' => 2]);
        $first = Banner::query()->create(['title' => 'First', 'image' => 'banners/a.jpg', 'sort_order' => 1]);

        Livewire::test(ListBanners::class)->assertCanSeeTableRecords([$first, $second], inOrder: true);
    }

    public function test_pages_are_edit_only_with_a_fixed_slug(): void
    {
        $this->seed(PageSeeder::class);
        $page = Page::query()->where('slug', 'about-federation')->firstOrFail();

        $this->get('/admin/pages/create')->assertNotFound();

        Livewire::test(ListPages::class)
            ->assertCanSeeTableRecords(Page::all())
            ->assertActionDoesNotExist(TestAction::make('delete')->table($page));

        Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
            ->assertActionDoesNotExist('delete')
            ->fillForm(['title' => 'About the Federation', 'slug' => 'hacked'])
            ->call('save')
            ->assertHasNoFormErrors();

        $page->refresh();
        $this->assertSame('About the Federation', $page->title);
        $this->assertSame('about-federation', $page->slug);
    }

    public function test_site_settings_update_existing_keys_and_clear_the_cache(): void
    {
        $this->seed(SettingSeeder::class);
        $keys = Setting::query()->count();
        $this->assertSame('jumpballfederationofindia@gmail.com', Setting::get('contact_email'));

        Livewire::test(SiteSettings::class)
            ->assertSchemaStateSet(['contact_email' => 'jumpballfederationofindia@gmail.com'], 'form')
            ->fillForm(['contact_email' => 'office@jfi.example', 'facebook_url' => 'https://facebook.com/jfi'], 'form')
            ->call('save')
            ->assertHasNoFormErrors([], 'form')
            ->assertNotified();

        $this->assertSame('office@jfi.example', Setting::get('contact_email'));
        $this->assertSame('https://facebook.com/jfi', Setting::get('facebook_url'));
        $this->assertSame($keys, Setting::query()->count());
    }

    public function test_site_settings_validate_urls(): void
    {
        $this->seed(SettingSeeder::class);

        Livewire::test(SiteSettings::class)
            ->fillForm(['facebook_url' => 'not a url', 'map_embed' => 'https://evil.example/frame'], 'form')
            ->call('save')
            ->assertHasFormErrors(['facebook_url', 'map_embed'], 'form');
    }

    private function association(string $name, RegistrationStatus $status): StateAssociation
    {
        $association = StateAssociation::query()->create(['name' => $name, 'state' => 'Goa', 'email' => str($name)->slug().'@example.com', 'phone' => '9800000000']);
        $association->forceFill(['status' => $status])->save();

        return $association;
    }
}
