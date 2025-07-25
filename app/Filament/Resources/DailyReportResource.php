<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyReportResource\Pages;
use App\Filament\Resources\DailyReportResource\RelationManagers;
use App\Models\Daily_report;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;


class DailyReportResource extends Resource
{
    protected static ?string $model = Daily_report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
public static function canCreate(): bool
{
    return false;
}

public static function canEdit($record): bool
{
    return false;
}


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('elderly.full_name')->label('المقيم')
                ->searchable(),
                TextColumn::make('user.name')->label('مقدم الرعاية'),
                TextColumn::make('mood')
                ->label('المزاج')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'good' => 'success',
                    'average' => 'warning',
                    'poor' => 'danger',
                }),

            TextColumn::make('sleep_quality')
                ->label('جودة النوم')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'good' => 'success',
                    'average' => 'warning',
                    'poor' => 'danger',
                }),

            TextColumn::make('appetite')
                ->label('الشهية')
                ->badge()
                ->color(fn ($state) => match($state) {
                    'good' => 'success',
                    'average' => 'warning',
                    'poor' => 'danger',
                }),
                TextColumn::make('notes')
                ->label('ملاحظات')
                ->limit(25)
                ->tooltip(fn ($record) => $record->notes),
                TextColumn::make('report_date')->label('تاريخ التقرير')->date(),

            ])

            ->filters([
            Filter::make('report_date')
                ->label('التاريخ')
                ->form([
                    Forms\Components\DatePicker::make('from')->label('من'),
                    Forms\Components\DatePicker::make('until')->label('إلى'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['from'], fn ($q, $date) => $q->whereDate('report_date', '>=', $date))
                        ->when($data['until'], fn ($q, $date) => $q->whereDate('report_date', '<=', $date));
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                    ->label('تصدير التقارير'),


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
            'index' => Pages\ListDailyReports::route('/'),
            'create' => Pages\CreateDailyReport::route('/create'),
            'edit' => Pages\EditDailyReport::route('/{record}/edit'),
        ];
    }
}
