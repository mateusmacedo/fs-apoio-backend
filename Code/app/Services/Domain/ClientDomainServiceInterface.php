<?php


namespace App\Services\Domain;


use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

interface ClientDomainServiceInterface
{
    public function solicitarChavesFromFile(UploadedFile $file): Response;

    public function cancelarChavesFromFile(UploadedFile $file): Response;
}
