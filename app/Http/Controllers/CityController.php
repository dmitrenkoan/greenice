<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Contracts\SortCity;

class CityController extends Controller
{
    public function index(Request $request, SortCity $sortCity) {

        $result = [];
        $result['nameSortItems'] = $sortCity->sortArrayName();
        $curCityKey = $request->input('city_name');
        if(!empty($curCityKey)) {
            $result['curCityName'] = $curCityKey;
            $result['setLocation'] = 'Y';
            $result['distanceSortItems'] = $sortCity->sortArrayDistance($curCityKey);
        }
        return view('layouts.city', $result);
    }
}
