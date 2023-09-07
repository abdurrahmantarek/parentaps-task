<?php

namespace App\Http\DataProviders;


class DataProviderConfig {
    public static $dpFilePathX;
    public static $dpFilePathY;

    public static function init() {
        self::$dpFilePathX = config('dataproviders.dp_x_path');
        self::$dpFilePathY = config('dataproviders.dp_y_path');
    }
}
