<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('عنوان الحدث')
                    ->required(),

                DatePicker::make('date')
                    ->label('تاريخ الحدث')
                    ->required(),

                Textarea::make('description')
                    ->label('الوصف')
                    ->required(),

                FileUpload::make('image_url')
                    ->label('صورة الحدث')
                    ->image()
                    ->directory('events')
                    ->nullable(),

                Select::make('target_type')
                    ->label('الفئة المستهدفة')
                    ->options([
                        'doctor' => 'أطباء',
                        'caregiver' => 'مقدمو الرعاية',
                        'resident' => 'مقيم معيّن',
                        'all' => 'الجميع',
                    ])
                    ->required()
                    ->reactive(), // ✅ لازم

                Select::make('elderly_id')
                    ->label('المقيم (عند الحاجة)')
                    ->relationship('elderly', 'full_name')
                    ->visible(fn($get) => $get('target_type') === 'resident')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('العنوان')->searchable(),
                TextColumn::make('date')->label('التاريخ')->date(),
                TextColumn::make('target_type')->label('موجه إلى'),
                TextColumn::make('elderly.full_name')->label('المقيم')->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('target_type')
                    ->label('الفئة المستهدفة')
                    ->options([
                        'doctor' => 'أطباء',
                        'caregiver' => 'مقدمو الرعاية',
                        'resident' => 'مقيم',
                        'all' => 'الجميع',
                    ]),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
