<?php


namespace App\Services\Application\Http\Interfaces;


use Illuminate\Http\Response;

interface WebConsumerInterface
{
    public function fetch(PayloadInterface $payload): Response;
}
