<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Enums\ArticleStatus;
use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            // tombol submit for review
            Actions\Action::make('submitReview')
                ->label('Ajukan Review')
                ->color('info')
                ->icon('heroicon-m-paper-airplane')
                ->visible(fn() => Auth::user()->role === 'author' && in_array($this->record->status, [ArticleStatus::DRAF, ArticleStatus::CHANGES_REQUESTED]))
                ->action(function () {
                    $this->record->update(['status' => ArticleStatus::PENDING_REVIEW]);
                    Notification::make()->success()->title('Artikel di kirim ke editor')->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
            // tombol publish (khusus editor dan admin)
            Actions\Action::make('publish')
                ->label('Terbitkan')
                ->color('success')
                ->icon('heroicon-m-check-badge')
                ->requiresConfirmation()
                ->visible(fn() => in_array(Auth::user()->role, ['admin', 'editor']) && $this->record->status !== ArticleStatus::PUBLISH)
                ->action(function () {
                    $this->record->update([
                        'status' => ArticleStatus::PUBLISH,
                        'published_at' => now(),
                    ]);
                    Notification::make()->success()->title('Artikel berhasil di terbitkan')->send();
                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            // tombol minta revisi
            Actions\Action::make('requestChange')
                ->label('Minta Revisi')
                ->color('warning')
                // muncul jika editor dan admin dan status pending review
                ->visible(fn() => in_array(Auth::user()->role, ['admin', 'editor']) && $this->record->status === ArticleStatus::PENDING_REVIEW)
                ->form([
                    \Filament\Forms\Components\Textarea::make('notes')
                        ->label('Catatan revisi')
                        ->required()
                        ->placeholder('Contoh: tolong perbaiki paragraf kedua...'),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => ArticleStatus::CHANGES_REQUESTED]);

                    Notification::make()
                        ->warning()
                        ->title('Status di ubah menjadi perlu di revisi')
                        ->body('Catatan: ' . $data['notes'])
                        ->send();

                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}
