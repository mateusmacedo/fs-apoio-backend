<?php


namespace App\Services\Application\Interfaces;


use Illuminate\Http\Response;

interface WebConsumerInterface
{
    public function fetch(PayloadInterface $payload): Response;
}
