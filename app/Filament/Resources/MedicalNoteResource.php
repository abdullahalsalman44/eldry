<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicalNoteResource\Pages;
use App\Filament\Resources\MedicalNoteResource\RelationManagers;
use App\Models\Medical_note;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
class MedicalNoteResource extends Resource
{
    protected static ?string $model = Medical_note::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('elderly_id')
                ->label('المقيم')
                ->relationship('elderly', 'full_name')
                ->required(),

            Textarea::make('note')
                ->label('الملاحظة الطبية')
                ->required(),

            Toggle::make('is_critical')
                ->label('حرجة؟')
                ->inline(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('elderly.full_name')->label('المقيم')->searchable(),
                TextColumn::make('note')->limit(30)->tooltip(fn ($record) => $record->note)->label('الملاحظة'),
                IconColumn::make('is_critical')->boolean()->label('حرجة؟'),
                TextColumn::make('created_at')->date()->label('التاريخ'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_critical')
                ->label('حالة حرجة؟')
                ->trueLabel('فقط الحرجة')
                ->falseLabel('فقط غير الحرجة')
        ->native(false),
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
            'index' => Pages\ListMedicalNotes::route('/'),
            'create' => Pages\CreateMedicalNote::route('/create'),
            'edit' => Pages\EditMedicalNote::route('/{record}/edit'),
        ];
    }
}
