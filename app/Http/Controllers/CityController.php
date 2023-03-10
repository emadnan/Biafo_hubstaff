<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
class CityController extends Controller
{
    public function get_cities($country_id){

        $cities = City::where('country_id',$country_id)
        ->get();
        return response()->json(['Cities' => $cities]);

    }
}
