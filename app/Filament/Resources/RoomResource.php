<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Filament\Resources\RoomResource\RelationManagers;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
class RoomResource extends Resource
{

    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canCreate(): bool
{
    return auth()->user()?->can('create_room');
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('number')
                        ->label('رقم الغرفة')
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('capacity')
                        ->label('الطاقة الاستيعابية')
                        ->numeric()
                        ->minValue(1)
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                ->label('رقم الغرفة')
                ->sortable()
                ->searchable(),

            TextColumn::make('capacity')
                ->label('الطاقة الاستيعابية'),

            TextColumn::make('status')
                ->label('الحالة')
                ->badge()
                ->formatStateUsing(fn ($state) =>
                    $state === 'available' ? 'متاحة' : 'مشغولة'
                )
                ->color(fn ($state) =>
                    $state === 'available' ? 'success' : 'danger'
                ),

            TextColumn::make('elderly_people_count')
                ->label('عدد المقيمين')
                ->counts('elderlyPeople'),
        ])
        ->filters([
            SelectFilter::make('status')
                ->label('الحالة')
                ->options([
                    'available' => 'متاحة',
                    'occupied' => 'مشغولة',
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
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
