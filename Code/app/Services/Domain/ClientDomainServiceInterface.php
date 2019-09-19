<?php


namespace App\Services\Domain;


use Illuminate\Http\UploadedFile;

interface ClientDomainServiceInterface
{
    public function solicitarChavesFromFile(UploadedFile $file);

    public function cancelarChavesFromFile(UploadedFile $file);
}
