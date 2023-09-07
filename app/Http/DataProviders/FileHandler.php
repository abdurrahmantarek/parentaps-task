<?php

namespace App\Http\DataProviders;

use Illuminate\Support\Facades\Storage;

class FileHandler {

    protected $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function fileExists()
    {
        return Storage::exists($this->filePath);
    }

    public function readJson()
    {
        if ($this->fileExists()) {
            return Storage::json($this->filePath);
        }

        throw new \Exception('File does not exist');
    }

    public function putJson($jsonData)
    {
        if ($this->fileExists()) {

            return Storage::put($this->filePath, $jsonData);
        }

        return false;
    }

    public function lastModified()
    {
        return Storage::lastModified($this->filePath);
    }
}
