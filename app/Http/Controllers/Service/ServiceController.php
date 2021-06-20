<?php

namespace App\Http\Controllers\Service;

use App\Enums\DayType;
use App\Enums\GuardType;
use App\Enums\LanguageType;
use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Timezone;
use App\Models\BusinessService;
use App\Models\BusinessServiceStaffMember;
use App\Models\BusinessStaffMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    //Team Page
    public function team($business){
 
        $business = Business::where('name', $business)->get()->first();
        $bid = $business->id;
        $staff = BusinessStaffMember::where('business_id', $bid)->get()->all(); 
        return view("service.index", ['staff'=> $staff])->with('business', $business);
    }

    //Staff Service List
    public function serviceList($id){
        $staff = BusinessStaffMember::find($id);
        $sid = BusinessServiceStaffMember::where('business_staff_member_id', $id)->value('business_service_id');
        $service = BusinessService::find($sid)->get();
     
        return view("service.list", compact('staff', $staff))->with('services', $service);

    }

    //Schedule Meeting 
    public function schedule($data){
                
    }

    //Book Meeting
    public function book($data){

    }


    /* to get staff related to service
    $data['name'] = $service;
        $data['serviceid'] = Business::where('name', $service)->value('id');
        $data['staffid'] = BusinessServiceStaffMember::where('business_service_id', $data['serviceid'])->value('business_staff_member_id');
        $staff = BusinessStaffMember::where('id', $data['staffid'])->get();
    */
}
?>