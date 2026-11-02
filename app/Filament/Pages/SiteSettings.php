<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Edits the keys seeded by SettingSeeder. Keys cannot be added or removed
 * here; values are saved through the Setting model so its cache is cleared.
 *
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Site Settings';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::query()->pluck('value', 'key')->all());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Contact')
                    ->description('Shown in the footer and on the Contact Us page.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('contact_phone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(30),
                        Textarea::make('contact_address')
                            ->label('Address')
                            ->rows(2)
                            ->maxLength(500)
                            ->columnSpanFull(),
                        TextInput::make('map_embed')
                            ->label('Google Maps embed link')
                            ->url()
                            ->maxLength(2000)
                            ->regex('#^https://www\.google\.com/maps/embed#')
                            ->validationMessages(['regex' => 'Paste the link that starts with https://www.google.com/maps/embed.'])
                            ->helperText('In Google Maps: Share → Embed a map → copy only the src="…" link.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Social links')
                    ->description('Leave empty to hide an icon.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facebook_url')->label('Facebook')->url()->maxLength(255),
                        TextInput::make('instagram_url')->label('Instagram')->url()->maxLength(255),
                        TextInput::make('youtube_url')->label('YouTube')->url()->maxLength(255),
                        TextInput::make('x_url')->label('X (Twitter)')->url()->maxLength(255),
                    ]),
                Section::make('Footer & SEO')
                    ->columns(2)
                    ->schema([
                        TextInput::make('site_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('tagline')
                            ->maxLength(255),
                        TextInput::make('footer_text')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('default_meta_description')
                            ->label('Default meta description')
                            ->rows(2)
                            ->maxLength(160)
                            ->helperText('Used by search engines for pages without their own description. Up to 160 characters.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Save settings')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ]),
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Only existing keys are updated; the form cannot create new ones.
        Setting::query()
            ->whereIn('key', array_keys($data))
            ->get()
            ->each(fn (Setting $setting) => $setting->update(['value' => $data[$setting->key]]));

        Notification::make()->success()->title('Settings saved')->send();
    }
}
