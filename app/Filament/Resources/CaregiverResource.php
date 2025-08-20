<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Caregiver;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CaregiverResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CaregiverResource\RelationManagers;

class CaregiverResource extends Resource
{
    //protected static ?string $navigationGroup = 'إدارة الموظفين';
    protected static ?string $navigationLabel = 'Caregiver';
    protected static ?string $model = \App\Models\User::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';




    public static function query(): Builder
    {
        return parent::query()->where('role', 'caregiver');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('الاسم')->required(),
                TextInput::make('email')->label('البريد الإلكتروني')->email()->required(),
                TextInput::make('phone')->label('رقم الهاتف')->nullable(),
                TextInput::make('password')
                    ->label('كلمة المرور')
                    ->password()
                    ->minLength(8)
                    ->nullable()
                    ->required(fn(string $context) => $context === 'create')
                    ->dehydrateStateUsing(fn($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn($state) => filled($state)),
                FileUpload::make('image')
                    ->label('الصورة')
                    ->image()
                    ->directory('caregiver')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->nullable(),
                Toggle::make('active')->label('الحساب مفعل؟')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('الاسم'),
                TextColumn::make('email')->label('البريد الإلكتروني'),
                TextColumn::make('phone')->label('رقم الهاتف'),
                IconColumn::make('active')->boolean()->label('الحساب مفعل؟'),
                TextColumn::make('created_at')->label('تاريخ الإنشاء')->date()

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
            'index' => Pages\ListCaregivers::route('/'),
            'create' => Pages\CreateCaregiver::route('/create'),
            'edit' => Pages\EditCaregiver::route('/{record}/edit'),
        ];
    }



    public static function mutateFormDataBeforeSave(array $data): array
    {
        $data['role'] = 'caregiver';
        return $data;
    }
}
