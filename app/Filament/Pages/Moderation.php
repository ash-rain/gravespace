<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\Tribute;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Moderation extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $navigationLabel = 'Moderation';

    protected static ?string $title = 'Moderation';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.moderation';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tribute::query()
                    ->pending()
                    ->with(['memorial'])
                    ->latest()
            )
            ->columns([
                TextColumn::make('author_name')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('body')
                    ->label('Content')
                    ->limit(80)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('memorial.first_name')
                    ->label('Memorial')
                    ->formatStateUsing(fn($record) => $record->memorial?->fullName() ?? '—')
                    ->sortable(),
                TextColumn::make('author_email')
                    ->label('Email')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_approved')
                    ->label('Status')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function (Tribute $record): void {
                        $record->update(['is_approved' => true]);

                        Notification::make()
                            ->title('Tribute approved')
                            ->success()
                            ->send();
                    }),
                \Filament\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (Tribute $record): void {
                        $record->update(['is_approved' => false]);

                        Notification::make()
                            ->title('Tribute rejected')
                            ->warning()
                            ->send();
                    }),
                \Filament\Actions\Action::make('delete')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(function (Tribute $record): void {
                        $record->delete();

                        Notification::make()
                            ->title('Tribute deleted')
                            ->danger()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('approveSelected')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records): void {
                            $records->each->update(['is_approved' => true]);

                            Notification::make()
                                ->title('Selected tributes approved')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No pending tributes')
            ->emptyStateDescription('All tributes have been reviewed. Great job!')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }
}
