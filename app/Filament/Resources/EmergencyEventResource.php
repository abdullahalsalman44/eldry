<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmergencyEventResource\Pages;
use App\Filament\Resources\EmergencyEventResource\RelationManagers;
use App\Models\Emergency_event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\TextColumn;
class EmergencyEventResource extends Resource
{
    protected static ?string $model = Emergency_event::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('elderly_id')
                ->label('المقيم')
                ->relationship('elderly', 'full_name')
                ->nullable()
                ->searchable(),

            Select::make('triggered_by')
                ->label('المبلّغ')
                ->relationship('reporter', 'name')
                ->searchable()
                ->required(),

            TextInput::make('type')
                ->label('نوع الحالة')
                ->required(),

            Textarea::make('description')
                ->label('الوصف')
                ->required(),

            CheckboxList::make('notified_roles')
                ->label('الأدوار التي تم إخطارها')
                ->options([
                    'admin' => 'الإدارة',
                    'doctor' => 'الأطباء',
                    'caregiver' => 'مقدمو الرعاية',
                    'family' => 'ذوو المقيم',
                ])
                ->columns(2)
                ->required(),

            DateTimePicker::make('occurred_at')
                ->label('وقت الحدوث')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->label('نوع الحالة'),
                TextColumn::make('elderly.full_name')->label('المقيم'),
                TextColumn::make('reporter.name')->label('المبلّغ'),
                TextColumn::make('occurred_at')->label('وقت الحدوث')->dateTime(),
                TextColumn::make('notified_roles')
                    ->label('الأدوار التي أُخطرت')
                    ->formatStateUsing(fn ($state) => is_array($state) ? implode(', ', $state) : $state)
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmergencyEvents::route('/'),
            'create' => Pages\CreateEmergencyEvent::route('/create'),
            'edit' => Pages\EditEmergencyEvent::route('/{record}/edit'),
        ];
    }
}
