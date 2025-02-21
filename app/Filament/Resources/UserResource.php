<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Select;
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
use Filament\Forms\Components\FileUpload;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Casts\Attribute;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-User-group';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\FileUpload::make('profile_photo_path') // Add the FileUpload component for profile photo
                ->label('Profile Photo')
                ->disk('public') // Specify the disk where the file will be stored
                ->directory('profile_photos') // Specify the directory within the disk
                ->required() // Make it required if necessary
                ->image() // Ensure the uploaded file is an image
                ->maxSize(1024) // Set a maximum file size (in kilobytes)
                ->preserveFilenames(), // Preserve the original filename
                Forms\Components\TextInput::make('first_name')
                ->required(),

                Forms\Components\TextInput::make('last_name')
                ->required(),

                Forms\Components\TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->maxlength(255)
                ->unique(ignoreRecord: true )
                ->required(),

                Forms\Components\DateTimePicker::make('email_verified_at')
                ->label('Email Verified At')
                ->default(now()),

                Forms\Components\TextInput::make('phone')
                ->label('Phone Number')
                ->tel() // This will set the field type to telephone
                ->maxlength(15) // You can adjust the maxlength based on your needs
                ->required() // Make the field required, as you did with email
                ->unique(ignoreRecord: true) // Ensure uniqueness, ignoring the current record
                ->rule('regex:/^\+?[1-9]\d{1,14}$/'), // Corrected regex for international phone number
            

                Forms\Components\TextInput::make('password')
                ->label('Password')
                ->password()
                ->dehydrated(fn($state) => filled($state))
                ->required(fn($livewire): bool => $livewire instanceof \App\Filament\Resources\UserResource\Pages\CreateUser),

                Select::make('role')
                ->options([
                    'admin' => 'Admin',
                    'manager' => 'Manager',
                    'dispatcher' => 'Dispatcher',
                    'driver' => 'Driver',
                ])
                ->required()
                ->default('driver'), // Default role

        

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([


                Tables\Columns\ImageColumn::make('profile_photo_path') // Use ImageColumn for the profile photo
                ->label('Profile Photo') // Set the label for the column
                ->disk('public') // Specify the disk where the image is stored
                ->sortable(), // Make it sortable if needed

                Tables\Columns\TextColumn::make('first_name')
                ->searchable(),

                Tables\Columns\TextColumn::make('last_name')
                ->searchable(),

                Tables\Columns\TextColumn::make('email')
                ->searchable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                ->dateTime()
                ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                ->searchable(),

                Tables\Columns\TextColumn::make('role')
                ->label('Role')
                ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
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
                    ->label('Download User Report')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn(User $record): string => route('user.download', ['id' => $record->id])) // Correct URL generation
                    ->openUrlInNewTab(),
                ])
    
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Action::make('Download Pdf')
                    ->label('Download All User Report')
                    ->icon('heroicon-o-document-arrow-down')
                    ->deselectRecordsAfterCompletion()
                    ->url(fn(): string => route('users.download.all')) 
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }


}
