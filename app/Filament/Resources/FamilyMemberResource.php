<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\FamilyMember;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FamilyMemberResource\Pages;
use App\Filament\Resources\FamilyMemberResource\RelationManagers;

class FamilyMemberResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Family';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->role('family');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('الاسم الكامل')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),

                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->label('الاسم')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('البريد')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->label('أُنشئ في')->dateTime(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFamilyMembers::route('/'),
            'create' => Pages\CreateFamilyMember::route('/create'),
            'edit' => Pages\EditFamilyMember::route('/{record}/edit'),
        ];
    }
}
