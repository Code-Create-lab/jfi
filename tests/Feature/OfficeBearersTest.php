<?php

namespace Tests\Feature;

use App\Enums\BearerLevel;
use App\Filament\Resources\OfficeBearers\Pages\CreateOfficeBearer;
use App\Filament\Resources\OfficeBearers\Pages\EditOfficeBearer;
use App\Filament\Resources\OfficeBearers\Pages\ListOfficeBearers;
use App\Models\OfficeBearer;
use App\Models\StateAssociation;
use App\Models\User;
use Database\Seeders\OfficeBearerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class OfficeBearersTest extends TestCase
{
    use RefreshDatabase;

    public function test_static_list_is_shown_when_no_bearers_exist(): void
    {
        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee('Who Runs the Federation')
            ->assertSee('Rupesh Utam')
            ->assertSee('Pune, Maharashtra');

        $this->get(route('frontend.office-bearers.national'))
            ->assertOk()
            ->assertSee('Ram Pravesh Kumar');
    }

    public function test_admin_managed_bearers_replace_the_static_list(): void
    {
        OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => 'Asha Menon', 'designation' => 'President', 'sort_order' => 2]);
        OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => 'Vikram Rao', 'designation' => 'Treasurer', 'sort_order' => 1]);

        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSeeInOrder(['Vikram Rao', 'Asha Menon'])
            ->assertDontSee('Rupesh Utam');
    }

    public function test_home_lists_every_national_bearer(): void
    {
        $names = ['Asha Menon', 'Vikram Rao', 'Kiran Das', 'Meera Pillai', 'Arjun Singh'];

        foreach ($names as $index => $name) {
            OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => $name, 'designation' => 'Vice President', 'sort_order' => $index + 1]);
        }

        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSeeInOrder($names);
    }

    public function test_unpublished_and_state_bearers_are_not_listed_nationally(): void
    {
        $association = StateAssociation::query()->create(['name' => 'Kerala Jumpball Association', 'state' => 'Kerala', 'email' => 'k@example.com', 'phone' => '9800000000']);
        OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => 'Hidden Person', 'designation' => 'President', 'is_published' => false]);
        OfficeBearer::query()->create(['level' => BearerLevel::State, 'state_association_id' => $association->id, 'name' => 'State Person', 'designation' => 'Secretary']);

        $this->get(route('frontend.office-bearers.national'))
            ->assertOk()
            ->assertDontSee('Hidden Person')
            ->assertDontSee('State Person')
            ->assertSee('Rupesh Utam');
    }

    public function test_seeder_creates_bearers_with_photos_once(): void
    {
        Storage::fake('public');

        $this->seed(OfficeBearerSeeder::class);
        $this->seed(OfficeBearerSeeder::class);

        $bearers = OfficeBearer::query()->orderBy('sort_order')->get();

        $this->assertSame(['Rupesh Utam', 'Ram Pravesh Kumar', 'Rajesh Ranjan'], $bearers->pluck('name')->all());
        $this->assertSame('Pune, Maharashtra', $bearers->first()->location);
        Storage::disk('public')->assertExists($bearers->pluck('photo')->all());
    }

    public function test_admin_can_list_create_and_edit_bearers(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create());

        $existing = OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => 'Vikram Rao', 'designation' => 'Treasurer']);

        Livewire::test(ListOfficeBearers::class)->assertCanSeeTableRecords([$existing]);

        Livewire::test(CreateOfficeBearer::class)
            ->fillForm([
                'name' => 'Asha Menon',
                'designation' => 'Vice President',
                'level' => BearerLevel::National->value,
                'location' => 'Kochi, Kerala',
                'photo' => UploadedFile::fake()->image('asha.jpg', 500, 600),
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $created = OfficeBearer::query()->where('name', 'Asha Menon')->firstOrFail();
        $this->assertSame('Kochi, Kerala', $created->location);
        Storage::disk('public')->assertExists($created->photo);

        Livewire::test(EditOfficeBearer::class, ['record' => $existing->getRouteKey()])
            ->fillForm(['designation' => 'Senior Treasurer'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('Senior Treasurer', $existing->fresh()->designation);
    }

    public function test_state_level_requires_an_association(): void
    {
        $this->actingAs(User::factory()->create());

        Livewire::test(CreateOfficeBearer::class)
            ->fillForm(['name' => 'State Person', 'designation' => 'Secretary', 'level' => BearerLevel::State->value])
            ->call('create')
            ->assertHasFormErrors(['state_association_id' => 'required']);
    }

    public function test_deleting_a_bearer_removes_its_uploaded_photo(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('office-bearers/old.jpg', 'x');

        $bearer = OfficeBearer::query()->create(['level' => BearerLevel::National, 'name' => 'Vikram Rao', 'designation' => 'Treasurer', 'photo' => 'office-bearers/old.jpg']);
        $bearer->delete();

        Storage::disk('public')->assertMissing('office-bearers/old.jpg');
    }
}
