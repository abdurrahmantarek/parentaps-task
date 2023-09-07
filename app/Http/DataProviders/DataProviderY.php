<?php

namespace App\Http\DataProviders;

use Illuminate\Support\Facades\Log;

class DataProviderY implements IDataProvider {

    private $fileHandler;
    private $data = [];

    public function __construct($filePath)
    {
        $this->fileHandler = new FileHandler($filePath);
    }
    private static $statusCodes = [
        100 => 'authorised',
        200 => 'decline',
        300 => 'refunded',
    ];

    public function read()
    {

        if (!$this->fileHandler->fileExists()) {

            Log::error("Data provider Y json file doesn't exists");

            throw new \RuntimeException("Data provider Y json file doesn't exist");
        }

        $data = $this->fileHandler->readJson();

        $this->fillData($data);

        return $this->data;
    }

    private static function getStatusCode($status)
    {
        return self::$statusCodes[$status];
    }

    public function fillData($data)
    {
        foreach ($data as $iterator) {

            $transformedDataRecord = DataTransformer::transform(
                $iterator['id'],
                $iterator['email'],
                $iterator['balance'],
                $iterator['currency'],
                self::getStatusCode($iterator['status']),
                $iterator['created_at'],
                "DataProviderY"
            );

            $this->data[] = $transformedDataRecord;
        }
    }
    public function lastModified() {
        return $this->fileHandler->lastModified();
    }

    public function save($data)
    {
        $jsonData = json_encode($data);

        return $this->fileHandler->putJson($jsonData);
    }
}
