<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElderlyPersonResource\Pages;
use App\Filament\Resources\ElderlyPersonResource\RelationManagers;
use App\Models\ElderlyPerson;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class ElderlyPersonResource extends Resource
{
    protected static ?string $model = ElderlyPerson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('full_name')
                        ->label('الاسم الكامل')
                        ->required()
                        ->maxLength(255),

                    DatePicker::make('date_of_birth')
                        ->label('تاريخ الميلاد')
                        ->required(),

                    Select::make('gender')
                        ->label('الجنس')
                        ->required()
                        ->options([
                            'male' => 'ذكر',
                            'female' => 'أنثى',
                        ]),

                    Select::make('room_id')
                        ->label('الغرفة')
                        ->relationship('room', 'number')
                        ->options(
                            \App\Models\Room::withCount('elderlyPeople')->get()
                                ->filter(fn($room) => $room->elderly_people_count < $room->capacity)
                                ->pluck('number', 'id')
                        )
                        ->required(),

                    DatePicker::make('login_at')
                        ->label('تاريخ الدخول')
                        ->default(now())
                        ->required(),

                    Select::make('family_id')
                        ->label('العائلة')
                        ->relationship(
                            name: 'family',
                            titleAttribute: 'name',
                            modifyQueryUsing: function ($query) {
                                $query->role('family');
                            }
                        )
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('الاسم الكامل')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('date_of_birth')
                    ->label('تاريخ الميلاد')
                    ->date(),

                TextColumn::make('gender')
                    ->label('الجنس')
                    ->badge()
                    ->formatStateUsing(fn(string $state) => $state === 'male' ? 'ذكر' : 'أنثى')
                    ->color(fn(string $state) => $state === 'male' ? 'primary' : 'pink'),

                TextColumn::make('room.number')
                    ->label('رقم الغرفة'),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->label('الجنس')
                    ->options([
                        'male' => 'ذكر',
                        'female' => 'أنثى',
                    ]),

                SelectFilter::make('room_id')
                    ->label('الغرفة')
                    ->relationship('room', 'number'),
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
            'index' => Pages\ListElderlyPeople::route('/'),
            'create' => Pages\CreateElderlyPerson::route('/create'),
            'edit' => Pages\EditElderlyPerson::route('/{record}/edit'),
        ];
    }
}
