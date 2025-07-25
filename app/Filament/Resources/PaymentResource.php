<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('elderly_id')
                ->relationship('elderly', 'full_name')
                ->label('المقيم')
                ->required(),

            TextInput::make('amount')
                ->label('المبلغ')
                ->numeric()
                ->required(),

            DatePicker::make('due_date')
                ->label('تاريخ الاستحقاق')
                ->required(),

            TextInput::make('invoice_number')
                ->label('رقم الفاتورة')
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('status')
                ->label('الحالة')
                ->options([
                    'pending' => 'بانتظار الدفع',
                    'paid' => 'مدفوع',
                    'unpaid' => 'غير مدفوع',
                ])
                ->required(),

            DatePicker::make('paid_at')
                ->label('تاريخ الدفع')
                ->nullable(),

            Select::make('paid_by')
                ->relationship('payer', 'name')
                ->label('تم الدفع بواسطة')
                ->searchable()
                ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('elderly.full_name')->label('المقيم'),
                TextColumn::make('amount')->label('المبلغ'),
                TextColumn::make('status')
                ->label('الحالة')
                ->badge()
                ->color(fn ($state) => match ($state) {
                    'paid' => 'success',
                    'pending' => 'warning',
                    'unpaid' => 'danger',
                }),
                TextColumn::make('due_date')->date()->label('تاريخ الاستحقاق'),
                TextColumn::make('paid_at')->dateTime()->label('تاريخ الدفع'),
                TextColumn::make('payer.name')->label('مدفوع بواسطة')->default('-'),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
