<?php

namespace App\Filament\Resources\DiplomaAcademicoResource\Pages;

use App\Filament\Resources\DiplomaAcademicoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiplomaAcademico extends EditRecord
{
    protected static string $resource = DiplomaAcademicoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
