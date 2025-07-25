<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationResource\Pages;
use App\Filament\Resources\MedicationResource\RelationManagers;
use App\Models\Medication;
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
use Filament\Tables\Columns\TextColumn;
class MedicationResource extends Resource
{
    protected static ?string $model = Medication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('elderly_id')
                ->relationship('elderly', 'full_name')
                ->label('المقيم')
                ->required(),

            TextInput::make('name')
                ->label('اسم الدواء')
                ->required(),

            TextInput::make('dosage')
                ->label('الجرعة')
                ->required(),

            Textarea::make('instructions')
                ->label('تعليمات إضافية')
                ->rows(3)
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('elderly.full_name')->label('المقيم'),
                TextColumn::make('name')->label('اسم الدواء'),
                TextColumn::make('dosage')->label('الجرعة'),
                TextColumn::make('instructions')->label('التعليمات')->limit(30)->tooltip(fn ($record) => $record->instructions),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListMedications::route('/'),
            'create' => Pages\CreateMedication::route('/create'),
            'edit' => Pages\EditMedication::route('/{record}/edit'),
        ];
    }
}
