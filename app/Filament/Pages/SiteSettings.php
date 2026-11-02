<?php

namespace App\Filament\Pages;

use App\Filament\Support\Media;
use App\Models\Setting;
use App\Support\Localization;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

/**
 * Edits the key/value rows of the `settings` table. Each field's state path
 * is the setting key, so `person.headline.en` maps to the `en` entry of the
 * `person.headline` setting.
 *
 * @property-read Schema $form
 */
class SiteSettings extends Page
{
    /**
     * Every setting key managed on this page.
     *
     * @var list<string>
     */
    public const KEYS = [
        'site.name',
        'person.full_name',
        'person.short_name',
        'person.headline',
        'person.photo',
        'person.cv_file',
        'person.available_for_work',
        'contact.email',
        'contact.notification_email',
        'contact.phone',
        'contact.whatsapp',
        'contact.address',
        'contact.map_url',
        'social.instagram',
        'social.linkedin',
        'social.github',
        'footer.cta_heading',
        'footer.cta_text',
        'seo.default_og_image',
    ];

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?int $navigationSort = 1;

    /**
     * @var array<string, mixed>|null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $data = [];

        foreach (Setting::query()->whereIn('key', self::KEYS)->get() as $setting) {
            data_set($data, $setting->key, $setting->value);
        }

        $this->form->fill($data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Tabs::make('settings')->tabs([
                    Tab::make('Profil')->icon(Heroicon::OutlinedUser)->schema([
                        Grid::make(2)->schema([
                            TextInput::make('site.name')->label('Nama situs')->required(),
                            TextInput::make('person.full_name')->label('Nama lengkap')->required(),
                            TextInput::make('person.short_name')->label('Nama panggilan'),
                            Toggle::make('person.available_for_work')->label('Tampilkan "Available for Freelancing"')->inline(false),
                        ]),
                        ...$this->bilingual('person.headline', 'Headline', Textarea::class),
                        Grid::make(2)->schema([
                            Media::image('person.photo', 'profile')->label('Foto profil'),
                            Media::document('person.cv_file', 'files')->label('File CV (PDF)'),
                        ]),
                    ]),
                    Tab::make('Kontak')->icon(Heroicon::OutlinedPhone)->schema([
                        Grid::make(2)->schema([
                            TextInput::make('contact.email')->label('Email publik')->email(),
                            TextInput::make('contact.notification_email')
                                ->label('Email penerima pesan formulir')
                                ->email()
                                ->helperText('Pesan dari formulir kontak dikirim ke alamat ini.'),
                            TextInput::make('contact.phone')->label('Nomor telepon')->tel(),
                            TextInput::make('contact.whatsapp')
                                ->label('Nomor WhatsApp')
                                ->helperText('Format internasional tanpa +, contoh: 6288226377174'),
                        ]),
                        ...$this->bilingual('contact.address', 'Alamat'),
                        TextInput::make('contact.map_url')->label('Link Google Maps')->url(),
                    ]),
                    Tab::make('Media Sosial')->icon(Heroicon::OutlinedShare)->schema([
                        TextInput::make('social.instagram')->label('Instagram')->url(),
                        TextInput::make('social.linkedin')->label('LinkedIn')->url(),
                        TextInput::make('social.github')->label('GitHub')->url(),
                    ]),
                    Tab::make('Footer')->icon(Heroicon::OutlinedMegaphone)->schema([
                        ...$this->bilingual('footer.cta_heading', 'Judul ajakan (CTA)'),
                        ...$this->bilingual('footer.cta_text', 'Teks ajakan (CTA)', Textarea::class),
                    ]),
                    Tab::make('SEO')->icon(Heroicon::OutlinedMagnifyingGlass)->schema([
                        Media::image('seo.default_og_image', 'seo')
                            ->label('Gambar default saat dibagikan (Open Graph)')
                            ->helperText('Dipakai jika halaman tidak punya gambar sendiri. Rekomendasi 1200×630 px.'),
                    ]),
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
                            ->label('Simpan')
                            ->submit('save')
                            ->keyBindings(['mod+s']),
                    ]),
                ]),
        ]);
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach (self::KEYS as $key) {
            Setting::query()->updateOrCreate(['key' => $key], ['value' => data_get($state, $key)]);
        }

        Notification::make()->success()->title('Pengaturan disimpan')->send();
    }

    /**
     * One input per supported locale for a translatable setting.
     *
     * @param  class-string<TextInput|Textarea>  $component
     * @return list<Grid>
     */
    private function bilingual(string $key, string $label, string $component = TextInput::class): array
    {
        return [
            Grid::make(2)->schema(array_map(
                fn (string $locale) => $component::make("{$key}.{$locale}")->label("{$label} (".strtoupper($locale).')'),
                Localization::locales(),
            )),
        ];
    }
}
