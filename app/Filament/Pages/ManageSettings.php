<?php

namespace App\Filament\Pages;

use App\Repositories\SettingRepository;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?string $title = 'Pengaturan website';
    protected static ?string $slug = 'settings';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = Auth::user();

        return $user && $user->role === 'admin';
    }

    public function mount(SettingRepository $settingRepository): void
    {
        $this->form->fill($settingRepository->getAll());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas')
                    ->schema([
                        FileUpload::make('site_logo')
                            ->label('logo website')
                            ->image()
                            ->directory('settings')
                            ->visibility('public'),
                        TextInput::make('site_name')
                            ->label('Nama Website')
                            ->required(),
                        TextInput::make('tagline')
                            ->label('Tagline'),
                    ])->columns(2),
                Section::make('Kotak Kami')
                    ->schema([
                        TextInput::make('contact_email')->email(),
                        TextInput::make('contact_phone')->tel(),
                        Textarea::make('contact_address')->rows(3),
                    ])->columns(2),
            ])->statePath('data');
    }

    public function save(SettingRepository $settingRepository): void
    {
        $settingRepository->update($this->form->getState());
        Notification::make()
            ->success()
            ->title('Pengaturan Berhasil disimpan')
            ->send();
    }
}
