<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MealResource\Pages;
use App\Filament\Resources\MealResource\RelationManagers;
use App\Models\Meal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
class MealResource extends Resource
{
    protected static ?string $model = Meal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('elderly_id')
                ->relationship('elderly', 'full_name')
                ->label('المقيم' )
                ->required(),

            Select::make('caregiver_id')
                ->relationship('caregiver', 'name')
                ->label('مقدم الرعاية')
                ->required(),

            DatePicker::make('date')
                ->label('تاريخ الوجبة')
                ->required(),

            Select::make('meal_type')
                ->label('نوع الوجبة')
                ->options([
                    'breakfast' => 'فطور',
                    'lunch' => 'غداء',
                    'dinner' => 'عشاء',
                ])
                ->required(),

            Select::make('status')
                ->label('الحالة')
                ->options([
                    'pending' => 'لم تُقدّم بعد',
                    'served' => 'تم التقديم',
                    'refused' => 'رفضها المقيم',
                ])
                ->required(),

            DateTimePicker::make('served_at')
                ->label('وقت التقديم')
                ->seconds(false),

            Textarea::make('notes')
                ->label('ملاحظات')
                ->rows(3)
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('elderly.full_name')->label('المقيم'),
            TextColumn::make('caregiver.name')->label('مقدم الرعاية'),
            TextColumn::make('meal_type')->label('الوجبة'),
            TextColumn::make('status')->label('الحالة')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'pending' => 'warning',
                    'served' => 'success',
                    'refused' => 'danger',
                }),
            TextColumn::make('date')->label('تاريخ الوجبة')->date(),
            TextColumn::make('served_at')->label('وقت التقديم')->dateTime(),
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
            'index' => Pages\ListMeals::route('/'),
            'create' => Pages\CreateMeal::route('/create'),
            'edit' => Pages\EditMeal::route('/{record}/edit'),
        ];
    }
}
