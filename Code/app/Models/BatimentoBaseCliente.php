<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatimentoBaseCliente extends Model
{
    protected $fileName;
    protected $fillable = [
        'operadora',
        'file'
    ];

    public function getFileName()
    {
        if (empty($this->fileName)) {
            $originalFileName = $this->file->getClientOriginalName();
            $extension = substr($originalFileName, strrpos($originalFileName, '.'), (strlen($originalFileName) - strrpos($originalFileName, '.')));
            $this->fileName = ucfirst($this->operadora) . DIRECTORY_SEPARATOR . 'Base' . date('dmYHis') . $extension;
        }
        return $this->fileName;
    }
}
