<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function canCreate(): bool
{
    return false;
}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Textarea::make('message')
                ->label('الاستفسار')
                ->disabled(),

            Select::make('elderly_id')
                ->relationship('elderly', 'full_name')
                ->label('المقيم المرتبط (اختياري)')
                ->disabled()
                ->nullable(),

            Textarea::make('response')
                ->label('الرد')
                ->nullable()
                ->visible(fn ($record) => $record && $record->status === 'pending')
                ->required(fn ($context) => $context === 'edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('المرسل'),
                TextColumn::make('message')->label('الاستفسار')->limit(40)->tooltip(fn ($record) => $record->message),
                TextColumn::make('status')
                ->label('الحالة')
                ->badge()
                ->color(fn ($state) => $state === 'answered' ? 'success' : 'warning'),
                TextColumn::make('created_at')->label('تاريخ الإرسال')->dateTime(),
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
            'index' => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }

    public static function mutateFormDataBeforeSave(array $data): array
{
    if (!empty($data['response'])) {
        $data['status'] = 'answered';
        $data['response_by'] = Auth::id();
    }

    return $data;
}




}
