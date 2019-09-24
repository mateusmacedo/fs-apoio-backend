<?php

namespace App\Exceptions;

use Exception;

class StorageException extends Exception
{
    public const BASE_PATH_NOT_FOUND = 'BasePath não definido para o serviço';
    public const NOT_FOUND = 'Arquivo não existe no armazenamento';
}
