<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MedicationScheduleResource\Pages;
use App\Filament\Resources\MedicationScheduleResource\RelationManagers;
use App\Models\Medication_schedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
class MedicationScheduleResource extends Resource
{
    protected static ?string $model = Medication_schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('medication_id')
                ->relationship('medication', 'name')
                ->label('اسم الدواء')
                ->required(),

            Select::make('caregiver_id')
                ->relationship('caregiver', 'name')
                ->label('مقدم الرعاية')
                ->required(),

            DatePicker::make('date')
                ->label('التاريخ')
                ->required(),

            TimePicker::make('time')
                ->label('الوقت')
                ->required(),

            Select::make('status')
                ->label('الحالة')
                ->options([
                    'scheduled' => 'مجدولة',
                    'given'     => 'تم إعطاؤه',
                    'missed'    => 'لم يُعطَ',
                    'delayed'   => 'مؤجل',
                ])
                ->required()
                ->default('scheduled'),

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
                TextColumn::make('medication.name')->label('الدواء'),
                TextColumn::make('caregiver.name')->label('مقدم الرعاية'),
                TextColumn::make('date')->label('التاريخ')->date(),
                TextColumn::make('time')->label('الوقت')->time(),
                TextColumn::make('status')->label('الحالة')
                    ->badge()
                    ->color(fn ($state) => match($state) {
                        'scheduled' => 'gray',
                        'given'     => 'success',
                        'missed'    => 'danger',
                        'delayed'   => 'warning',
                    }),
                TextColumn::make('notes')
                    ->label('ملاحظات')
                    ->limit(20)
                    ->tooltip(fn ($record) => $record->notes),
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
            'index' => Pages\ListMedicationSchedules::route('/'),
            'create' => Pages\CreateMedicationSchedule::route('/create'),
            'edit' => Pages\EditMedicationSchedule::route('/{record}/edit'),
        ];
    }
}
