<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DriverResource\Pages;
use App\Models\Driver;
use App\Models\User;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverResource extends Resource
{
    protected static ?string $model = Driver::class; // Ensure this references Driver, not User
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 2;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user'); // Load related user details
    }
    protected static function fillUserDetails($userId, callable $set)
    {
        if ($userId) {
            $user = User::find($userId);
            if ($user) {
                $set('user.first_name', $user->first_name);
                $set('user.last_name', $user->last_name);
                $set('user.email', $user->email);
                $set('user.phone', $user->phone);
            }
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->label('Driver')
                ->options(
                    User::where('role', 'driver')->pluck('first_name', 'id'))
                ->searchable()
                ->preload()
                ->required()
                ->reactive() // Make this field reactive, triggering updates on selection
                ->afterStateUpdated(fn ($state, callable $set) => self::fillUserDetails($state, $set)),

                // Personal Details
                Forms\Components\TextInput::make('user.first_name')
                    ->label('First Name')
                    ->required()
                    ->disabled(),

                Forms\Components\TextInput::make('user.last_name')
                    ->label('Last Name')
                    ->required()
                    ->disabled(),

                     
                Forms\Components\TextInput::make('user.email')
                    ->label('Email')
              ->email()
                    ->required()
                    ->disabled(),

                Forms\Components\TextInput::make('user.phone')
                    ->label('Phone Number')
                    ->tel()
             ->required()
                    ->disabled(),

                Forms\Components\DatePicker::make('dob')
                    ->label('Date of Birth')
                    ->required(),

                // Identification & Licensing
                Forms\Components\TextInput::make('license_number')
                    ->label('License Number')
                    ->required(),
                Forms\Components\Select::make('license_class')
                    ->label('License Class (A, B, C)')
                    ->options([
                        'A' => 'Class A',
                        'B' => 'Class B',
                        'C' => 'Class C',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('license_expiry')
                    ->label('License Expiry Date')
                    ->required(),
                Forms\Components\FileUpload::make('driver_license')
                    ->label('Driver License Upload')
                    ->directory('licenses'),

                // Employment Details
                Forms\Components\DatePicker::make('hiring_date')
                    ->label('Hiring Date')
                    ->required(),
                Forms\Components\Select::make('employment_status')
                    ->label('Employment Status')
                    ->options([
                        'Active' => 'Active',
                        'Suspended' => 'Suspended',
                        'Terminated' => 'Terminated',
                    ])
                    ->default('Active'),

                // Compliance & Safety
                Forms\Components\DatePicker::make('medical_card_expiry')
                    ->label('Medical Card Expiry')
                    ->required(),
                Forms\Components\Toggle::make('hazmat_certified')
                    ->label('Hazmat Certified')
                    ->default(false),
                Forms\Components\TextInput::make('violation_count')
                    ->label('Violations')
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('accident_count')
                    ->label('Accidents')
                    ->numeric()
                    ->default(0),

                // Payroll
                Forms\Components\TextInput::make('total_earnings')
                    ->label('Total Earnings ($)')
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('insurance_fee')
                    ->label('Insurance Fee Deducted ($)')
                    ->numeric()
                    ->default(0.00),

                // Availability
                Forms\Components\Select::make('availability')
                    ->label('Availability')
                    ->options([
                        'available' => 'Available',
                        'on_trip' => 'On Trip',
                        'off_duty' => 'Off Duty',
                    ])
                    ->default('available')
                    ->required(),
            ]);
    }

 public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('user.first_name')
                ->label('First Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.last_name')
                ->label('Last Name')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.email')
                ->label('Email')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('user.phone')
                ->label('Phone Number')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('license_number')
                ->label('License Number')
                ->sortable(),

            Tables\Columns\TextColumn::make('employment_status')
                ->label('Employment Status')
                ->badge()
                ->colors([
                    'success' => 'Active',
                    'warning' => 'Suspended',
                    'danger' => 'Terminated',
                ]),

            Tables\Columns\BadgeColumn::make('availability')
                ->label('Availability')
                ->colors([
                    'success' => 'available',
                    'warning' => 'on_trip',
                    'danger' => 'off_duty',
                ]),

            Tables\Columns\TextColumn::make('total_earnings')
                ->label('Total Earnings ($)')
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('employment_status')
                ->label('Employment Status')
                ->options([
                    'Active' => 'Active',
                    'Suspended' => 'Suspended',
                    'Terminated' => 'Terminated',
                ]),

            Tables\Filters\SelectFilter::make('availability')
                ->label('Availability')
                ->options([
                    'available' => 'Available',
                    'on_trip' => 'On Trip',
                    'off_duty' => 'Off Duty',
                ]),
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
                    ->url(fn(Driver $record): string => route('trucks.download', ['id' => $record->id])) // Correct URL generation
                    ->openUrlInNewTab(),

                ])
    
                ])
                ->bulkActions([
                    Tables\Actions\BulkActionGroup::make([
                        Tables\Actions\DeleteBulkAction::make(),
                        Tables\Actions\Action::make('Download Pdf')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDrivers::route('/'),
            'create' => Pages\CreateDriver::route('/create'),
            'edit' => Pages\EditDriver::route('/{record}/edit'),
        ];
    }

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->where('role', 'driver');
    }
}
