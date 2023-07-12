<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    function add_company(){
        $company = new Company();
        $company->company_name = \Request::input('company_name');
        $company->address = \Request::input('address');
        $company->company_email = \Request::input('company_email');
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
            'company_email' => \Request::input('company_email'),
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

    public function get_company_by_id($id){
        
        $company = Company::where('id',$id)->get();
        
        return response()->json(['company' => $company]);
    }

    public function get_company_by_company_id($id){
        
        $user = User::where('company_id',$id)->get();
        
        return response()->json(['users' => $user]);
    }
    public function getCompanyByUserId($user_id){
        
        $company = User::where('users.id',$user_id)->join('company','company.id','users.company_id')
        ->get();
        return response()->json(['companyDetails' => $company]);
    }
}
