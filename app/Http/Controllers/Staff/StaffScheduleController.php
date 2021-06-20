<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Enums\BooleanType;
use App\Enums\DayType;
use App\Enums\GuardType;
use App\Enums\StatusType;
use App\Http\Controllers\Controller;
use App\Models\StaffSchedule;
use App\Models\StaffScheduleDay;
use App\Models\Timezone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class StaffScheduleController extends Controller
{
    public function index()
    {
        $user = auth()->guard(GuardType::STAFF)->user();
        $schedules = StaffSchedule::where('staff_id', $user->id)->get();
        //$schedules = $user->schedules;
        return view('staff.staffSchedule.index', compact('schedules'));
    }

    public function create()
    {
        $booleanTypes = BooleanType::getItems();
        $timezones = Timezone::orderBy("region", 'asc')->get();
        return view('staff.staffSchedule.create', compact('booleanTypes', 'timezones'));
    }

    public function edit(StaffSchedule $staffSchedule)
    {
        $booleanTypes = BooleanType::getItems();
        $timezones = Timezone::orderBy("region", 'asc')->get();
        $staffScheduleDay = StaffScheduleDay::where('staff_schedule_id', $staffSchedule->id)->get();
        $data = [
            'booleanTypes' => $booleanTypes,
            'timezones' => $timezones,
            'staffSchedule' => $staffSchedule,
            'staffScheduleDay' => $staffScheduleDay
        ];
        
        $method = "edit";
        
        return view('staff.staffSchedule.edit', $data)->with('method', $method);
    }

    public function store(Request $request)
    {
        $staff = auth()->guard(GuardType::STAFF)->user();
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('staff_schedules')->where('staff_id', $staff->id)],
            'timezone' => ['required', 'string']
        ])->validate();

        $data = $request->all();
        $data['staff_id'] = $staff->id;
        
        
        $staffSchedule = StaffSchedule::create($data);

        if (!$staffSchedule) return redirect()->route('staff.staffSchedule.create')->withInput();

        foreach (DayType::getItems() as $day)
        {
            StaffScheduleDay::create([
                'staff_schedule_id' => $staffSchedule->id,
                'day' => $day
            ]);
        }
        return redirect()->route('staff.staffSchedule.edit', $staffSchedule->id)->with('success', trans('messages.itemCreated'));
    }

    public function update(Request $request, StaffSchedule $staffSchedule)
    {
        $staff = auth()->guard(GuardType::STAFF)->user();

        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', Rule::unique('staff_schedules')->where('staff_id', $staff->id)->ignoreModel($staffSchedule)],
            'timezone' => ['required', 'string']
        ])->validate();

        $staffSchedule->update($request->all());
        $method = "edit";

        return redirect()->route('staff.staffSchedule.edit', $staffSchedule->id)->with('success', trans('messages.itemUpdated'))->with('method', $method);
    }

    public function makeDefault(StaffSchedule $staffSchedule)
    {
        $staff = auth()->guard(GuardType::STAFF)->user();
        $schedule_id = StaffSchedule::where('staff_id', $staff->id)->pluck("id");
        StaffSchedule::whereIn('id', $schedule_id)->update(["is_default" => "no"]);
        $staffSchedule->update(["is_default" => "yes"]);

        return redirect()->route('staff.staffSchedule.edit', $staffSchedule->id)->with('success', trans('messages.itemUpdated'));
    }

    public function changeDayStatus(StaffScheduleDay $staffScheduleDay)
    {
        $status = ($staffScheduleDay->status == StatusType::ACTIVE) ? StatusType::DISABLED : StatusType::ACTIVE;
        $staffScheduleDay->update(['status' => $status]);
        return redirect()->route('staff.staffSchedule.edit', $staffScheduleDay->staff_schedule_id)->with('success', trans('messages.itemUpdated'));
    }

   public function hour(Request $request)
    { 
        function get_numerics ($str) {
            preg_match_all('/\d+/', $str, $matches);
            return $matches[0];
        }
        $data = $request->all();
        $keys = array_keys($data);
        $staffSchedule = StaffSchedule::where('id', $data['staff_schedule_id'])->first();
        $start = array();
        $end = array();
        foreach($keys as $k){
            if(strpos($k, 'start')){
                array_push($start, get_numerics($k)[0]);
                
            }
            if(strpos($k, 'end')){
                array_push($end, get_numerics($k)[0]);
                
            }
        }

        for($i = 0; $i < count($start) ; $i++){
            $schedule = staffScheduleDay::find($start[$i]);
            $schedule->start_time = json_encode($data[$start[$i] . '_start_time']);
            $schedule->end_time = json_encode($data[$end[$i] . '_end_time']);
            $schedule->save();
        }
        return redirect()->route('staff.staffSchedule.edit', $staffSchedule->id)->with('success', trans('messages.itemUpdated'))->with('method', 'edit');
        
    }


}
