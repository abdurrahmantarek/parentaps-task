<?php

namespace App\Http\DataProviders;


interface IDataProvider {
    public function read();
    public function save($data);
}
