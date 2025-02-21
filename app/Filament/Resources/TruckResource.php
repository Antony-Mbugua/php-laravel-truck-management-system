<?php

namespace App\Filament\Resources;


use App\Filament\Resources\TruckResource\Pages;
use App\Filament\Resources\TruckResource\RelationManagers;
use App\Models\Truck;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\Action;
use App\Services\TruckServicePdf;
use Illuminate\Database\Eloquent\Collection;


class TruckResource extends Resource
{
    protected static ?string $model = Truck::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('truck_vin')
                ->required()
                ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('license_plate')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('model')
                    ->required(),
                Forms\Components\TextInput::make('manufacturer')
                    ->required(),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->numeric(),
                FileUpload::make('photo') // Add file upload field
                    ->image()
                    ->directory('trucks') // Store files in the "trucks" directory
                    ->visibility('public') // Set visibility (optional)
                    ->preserveFilenames(), // Preserve original filenames (optional)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('truck_vin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('license_plate')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('manufacturer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('photo')
                    ->visible()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(), 
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('downloadPdf')
                    ->label('Download PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    //->action(function (Truck $record, TruckServicePdf $pdfService) {
                        //return $pdfService->generateTruckPdf($record);
                    //})
                    ->url(fn(Truck $record): string => route('trucks.download', ['id' => $record->id])) // Correct URL generation
                    ->openUrlInNewTab(),

                ])
    
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Action::make('Download Pdf')
                    ->label('Download All Trucks Data')
                    //->url(fn(Truck $record): string => route('trucks.downloadAll', ['?' => $record->id]))
                    ->icon('heroicon-o-document-arrow-down')
                    //->action(function (Collection $records, TruckServicePdf $pdfService) {
                        //return $pdfService->generateMultipleTrucksPdf($records);
                    //})
                    ->deselectRecordsAfterCompletion()
                    ->url(fn(): string => route('trucks.download.all')) // Correct URL generation without parameters
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListTrucks::route('/'),
            'create' => Pages\CreateTruck::route('/create'),
            'edit' => Pages\EditTruck::route('/{record}/edit'),
        ];
    }
}
