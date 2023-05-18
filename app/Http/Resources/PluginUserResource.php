<?php

namespace App\Http\Resources;

use App\Filament\Resources\PluginUserResource\Pages;
use App\Filament\Resources\PluginUserResource\RelationManagers;
use App\Models\PluginUser;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class PluginUserResource extends Resource
{
    const STATUS_ARRAY = [
        PluginUser::ACTIVE => 'Activate',
        PluginUser::INACTIVE => 'Deactivate',
        PluginUser::UNINSTALL => 'Uninstalled',
    ];
    protected static ?string $model = PluginUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make(array(
                    Forms\Components\TextInput::make('name')
                        ->maxLength(20)
                        ->placeholder("Name of user's plugin"),
                    Forms\Components\TextInput::make('version')
                        ->required()
                        ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('0.0.0'))
                        ->maxLength(10)
                        ->placeholder('current version of plugin'),
                    Forms\Components\TextInput::make('website')
                        ->url()
                        ->suffixAction(fn (?string $state): Action =>
                        Action::make('visit')
                            ->icon('heroicon-s-external-link')
                            ->url(
                                filled($state) ? "https://{$state}" : null,
                                shouldOpenInNewTab: true,
                            ),
                        )
                        ->maxLength(100)
                        ->placeholder('User website'),
                ))->columns(3),
                Forms\Components\Card::make([
                    Forms\Components\KeyValue::make('plugins')
                        ->keyLabel('#')
                        ->disableEditingKeys(true)
                        ->valueLabel('Name'),
                    Forms\Components\KeyValue::make('server')
                        ->keyLabel('#')
                        ->disableEditingKeys(true)
                        ->valueLabel('Software'),
                ])->columns(),

                Forms\Components\Card::make([
                    Forms\Components\DatePicker::make('activated_at')
                        ->required()
                        ->placeholder('month day, year'),
                    Forms\Components\DatePicker::make('deactivated_at')
                        ->placeholder('month day, year'),
                    Forms\Components\DatePicker::make('uninstalled_at')
                        ->placeholder('month day, year'),
                    Forms\Components\Radio::make('status')
                        ->options(self::STATUS_ARRAY),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('version')->searchable(),
                Tables\Columns\TextColumn::make('website')
                    ->url(function (PluginUser $record): string {
                        return $record->website;
                    }, true)
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'deactivate',
                        'success' => 'activate',
                        'danger' => 'uninstalled',
                    ])
                    ->icons([
                        'heroicon-o-x' => 'deactivate',
                        'heroicon-o-check' => 'activate',
                        'heroicon-o-trash' => 'uninstalled',
                    ])
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(self::STATUS_ARRAY),
                Tables\Filters\Filter::make('activated_at')
                    ->form([
                        Forms\Components\DatePicker::make('activated_from')->default(now()->startOfMonth()),
                        Forms\Components\DatePicker::make('activated_until')->default(now()->endOfMonth()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['activated_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('activated_at', '>=', $date),
                            )
                            ->when(
                                $data['activated_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('activated_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => \App\Http\Resources\PluginUserResource\Pages\ListPluginUsers::route('/'),
            'create' => \App\Http\Resources\PluginUserResource\Pages\CreatePluginUser::route('/create'),
            'edit' => \App\Http\Resources\PluginUserResource\Pages\EditPluginUser::route('/{record}/edit'),
        ];
    }
}
