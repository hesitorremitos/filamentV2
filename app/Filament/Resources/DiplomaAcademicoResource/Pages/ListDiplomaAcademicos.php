<?php

namespace App\Filament\Resources\DiplomaAcademicoResource\Pages;

use App\Filament\Resources\DiplomaAcademicoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDiplomaAcademicos extends ListRecords
{
    protected static string $resource = DiplomaAcademicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
