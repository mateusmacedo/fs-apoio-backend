<?php


namespace App\Services\Domain;


use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

interface ClientDomainServiceInterface
{
    public function solicitarChavesFromFile(UploadedFile $file): Response;

    public function cancelarChavesFromFile(UploadedFile $file): Response;

    public function subscriptionClientesFromFile(UploadedFile $file): Response;

    public function presaleClientesFromFile(UploadedFile $file): Response;
}
