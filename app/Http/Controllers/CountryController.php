<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function get_country(){
        $country = Country::get();
        return response()->json(['Country' => $country]);

    }
}
