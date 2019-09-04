<?php


namespace App\Services\Application\Interfaces;


interface PayloadInterface
{
    public function getMethod(): string;

    public function getUri(): string;

    public function getHeaders(): array;

    public function getBody(): array;

    public function __toString(): string;
}
