<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('name')
                        ->label('الاسم')
                        ->required(),

                    TextInput::make('email')
                        ->label('البريد الإلكتروني')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true),

                    TextInput::make('phone')
                        ->label('رقم الهاتف')
                        ->tel()
                        ->nullable(),

                    Select::make('role')
                        ->label('الدور')
                        ->options([
                            'admin' => 'إدارة',
                            'doctor' => 'طبيب',
                            'caregiver' => 'مقدم رعاية',
                            'family' => 'فرد عائلة',
                        ])
                        ->required()
                        ->native(false),

                    TextInput::make('password')
                        ->label('كلمة المرور')
                        ->password()
                        ->minLength(8)
                        ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                        ->required(fn (string $context) => $context === 'create')
                        ->dehydrated(fn ($state) => filled($state)),

                ]),
                Toggle::make('active')
                ->label('الحساب مفعل؟')
                ->onColor('success')
                ->offColor('danger')
                ->inline(false)
                ->default(true),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم')->searchable(),
            TextColumn::make('email')->label('البريد الإلكتروني')->searchable(),
            TextColumn::make('phone')->label('الهاتف'),
            TextColumn::make('role')
                ->label('الدور')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'admin' => 'danger',
                    'doctor' => 'info',
                    'caregiver' => 'success',
                    'family' => 'gray',
                }),
                IconColumn::make('active')
                ->label('الحالة')
                ->boolean()
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->trueColor('success')
                ->falseColor('danger'),

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
