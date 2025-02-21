<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip;
use App\Models\Truck;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\Document;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('truck_id')
                ->label('Truck')
                ->options(Truck::query()->pluck('model', 'id')) // Query-based for performance
                ->required()
                ->live(), // Reactive field

            Forms\Components\Select::make('user_id')
                ->label('Driver')
                ->options(function (callable $get) {
                    $userId = $get('user_id');
                    return $userId 
                        ? User::where('role', 'driver')->pluck('first_name', 'id') 
                        : [];
                })
                ->searchable()
                ->preload()
                ->required()
                ->reactive() // Updates dynamically
                ->afterStateUpdated(fn ($state, callable $set) => self::fillUserDetails($state, $set)),

            Forms\Components\DatePicker::make('trip_date')
                ->required(),

            Forms\Components\Toggle::make('is_active') // Fixed casing to match standard Laravel naming conventions
                ->required(),

            Forms\Components\TextInput::make('status')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('truck.model') // Fixed column reference
                ->sortable(),

            Tables\Columns\TextColumn::make('driver.first_name') // Fixed column reference
                ->sortable(),

            Tables\Columns\TextColumn::make('trip_date')
                ->date()
                ->sortable(),

            Tables\Columns\TextColumn::make('status'),

            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
