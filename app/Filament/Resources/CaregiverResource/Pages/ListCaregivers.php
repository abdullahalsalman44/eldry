<?php

namespace App\Filament\Resources\CaregiverResource\Pages;



use App\Filament\Resources\CaregiverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ListCaregivers extends ListRecords
{
    protected static string $resource = CaregiverResource::class;

    public function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->query(fn () => \App\Models\User::query()->where('role', 'caregiver'))
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('name')->label('الاسم'),
                \Filament\Tables\Columns\TextColumn::make('email')->label('البريد الإلكتروني'),
                \Filament\Tables\Columns\TextColumn::make('phone')->label('رقم الهاتف'),
                \Filament\Tables\Columns\IconColumn::make('active')->boolean()->label('الحساب مفعل؟'),
                \Filament\Tables\Columns\TextColumn::make('created_at')->label('تاريخ الإنشاء')->date(),
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
