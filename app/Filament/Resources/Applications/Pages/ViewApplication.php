<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use CodeWithDennis\FilamentLucideIcons\Enums\LucideIcon;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewApplication extends ViewRecord
{
    protected static string $resource = ApplicationResource::class;

    public function handleDeleteComment($commentId)
    {
        $comment = \App\Models\ApplicationComment::find($commentId);

        if ($comment && (auth()->user()->hasRole(['super_admin']) || $comment->user_id === auth()->id())) {
            $comment->delete();

            $this->dispatch('close-modal', id: "confirm-comment-deletion-{$commentId}");

            Notification::make()
                ->title(__('application.comment.notification.deleted'))
                ->success()
                ->send();
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->icon(LucideIcon::Edit),
            Action::make('addComment')
                ->label(__('application.comment.action.add'))
                ->modalHeading(__('application.comment.action.add_modal_heading'))
                ->icon(LucideIcon::MessageCircle)
                ->color('success')
                ->schema([
                    RichEditor::make('body')
                        ->label(__('application.comment.field.body'))
                        ->required()
                        ->columnSpanFull(),
                ])
                ->action(function (array $data): void {
                    $this->record->comments()->create([
                        'user_id' => auth()->id(),
                        'body' => $data['body'],
                    ]);

                    Notification::make()
                        ->title(__('application.comment.notification.added'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
