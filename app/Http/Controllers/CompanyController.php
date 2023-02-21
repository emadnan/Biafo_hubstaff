<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function add_company(){
        $company = new Company();
        $company->company_name = \Request::input('company_name');
        $company->address = \Request::input('address');
        $company->contact_no = \Request::input('contact_no');
        $company->city = \Request::input('city');
        $company->country = \Request::input('country');
        $company->save();
        return response()->json(['message'=>'Add Company successfully']);
    }

    function update_company(){
        $id = \Request::input('id');
        $company = Company::where('id',$id)
        ->update([
            'company_name' => \Request::input('company_name'),
            'address' => \Request::input('address'),
            'contact_no' => \Request::input('contact_no'),
            'city' => \Request::input('city'),
            'country' => \Request::input('country'),
        ]);

        return response()->json(['Message' => 'Company Updated']);
    }

    public function get_company()
    {
        $company = Company::get();
        return response()->json(['companies' => $company]);
    }
    
    function delete_company(){
        $id = \Request::input('id');
        $company = Company::where('id',$id)->delete();

        return response()->json(['message'=>'delete company successfully']);
    }
}
