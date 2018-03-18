<?php

namespace App\Helpers;

use App\Helpers\Contracts\SortCity;
use Illuminate\Filesystem\Filesystem;

class SortCitiesFile implements SortCity {
    public $locations = array();
    private $locationStoragePath = 'framework/locations/areas.php';
    function __construct() {

        $objFile = new Filesystem();
        $this->locations = $objFile->getRequire(storage_path($this->locationStoragePath));
    }

    public function sortArrayName() {
        // сортируем элементы по имени
        $arResult = $this->locations;
        ksort($arResult);
        return $arResult;
    }

    public function sortArrayDistance($arCityKey){
        $arCurCity = $this->locations[$arCityKey];
        foreach($this->locations as $name => $arLocation) {
            $arLocation['distance'] = $this->calculateDistance($arCurCity['lat'], $arCurCity['long'], $arLocation['lat'], $arLocation['long']);
            $arResult[$name] = $arLocation;
        }

        $resultCollection = collect($arResult);
        $arSortResult = $resultCollection->sortBy('distance');
        return $arSortResult;
    }

    public function calculateDistance ($φA, $λA, $φB, $λB) {
        $earthRadius = 6372795;
        // перевести координаты в радианы
        $lat1 = $φA * M_PI / 180;
        $lat2 = $φB * M_PI / 180;
        $long1 = $λA * M_PI / 180;
        $long2 = $λB * M_PI / 180;

        // косинусы и синусы широт и разницы долгот
        $cl1 = cos($lat1);
        $cl2 = cos($lat2);
        $sl1 = sin($lat1);
        $sl2 = sin($lat2);
        $delta = $long2 - $long1;
        $cdelta = cos($delta);
        $sdelta = sin($delta);

        // вычисления длины большого круга
        $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
        $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

        // вычеслении дистанции в км
        $ad = atan2($y, $x);
        $dist = number_format($ad * $earthRadius/1000, 2);

        return $dist;
    }
}