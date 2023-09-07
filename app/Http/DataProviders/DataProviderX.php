<?php

namespace App\Http\DataProviders;

use Illuminate\Support\Facades\Log;

class DataProviderX implements IDataProvider {

    private $fileHandler;
    private $data = [];

    public function __construct($filePath)
    {
        $this->fileHandler = new FileHandler($filePath);
    }
    private static $statusCodes = [
        1 => 'authorised',
        2 => 'decline',
        3 => 'refunded',
    ];

    public function read()
    {
        if (!$this->fileHandler->fileExists()) {

            Log::error("Data provider X json file doesn't exist");

            throw new \RuntimeException("Data provider X json file doesn't exist");
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
                $iterator['parentIdentification'],
                $iterator['parentEmail'],
                $iterator['parentAmount'],
                $iterator['Currency'],
                self::getStatusCode($iterator['statusCode']),
                $iterator['registerationDate'],
                "DataProviderX"
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
