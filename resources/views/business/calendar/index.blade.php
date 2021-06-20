@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.calendar'))
@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-calendar"></i> @lang('messages.calendar')
        </h1>
    </div>
    <!-- End Page Heading -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 class="modale-heading" id="eventModalLabel" style="color:black">Edit Availability</h5>
                    <div class="ava-repeat">
                        <div class="row">
                            <div class="col-6">
                                <p>from</p>
                                <input placeholder="HH:MM" style="width: 100%;">
                            </div>
                            <div class="col-6">
                                <p>until</p>
                                <input placeholder="HH:MM" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="multiple-ava">
                    
                    </div>
                    <button type="button" class="btn btn-success" onclick="addAvaHandler()">Add another availability</button>
                </div>
                <div class="modal-footer d-flex flex-column">
                    
                    <div class="row">
                    
                        <div class="col-6">
                            <input type="radio" id="" name="dateselect" value="only this day">
                            <label for="only this day">Only this day</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="weekday-input"  name="dateselect" value="weekday">
                            <label for="weekday">Weekdays</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="" name="dateselect" value="all days">
                            <label for="all days">All days</label>
                        </div>
                        <div class="col-6">
                            <input type="radio" id="" name="dateselect" value="selected days">
                            <label for="selected days">Selected days</label>
                        </div>
                        
                    
                    </div>

                    <div class="row weekday-list" style="display: none;">
                        <div class="col-6">
                            <input type="checkbox" id="" name="day" value="Monday">
                            <label for="only this day">Monday</label>
                        </div>
                        <div class="col-6">
                            <input type="checkbox" id=""  name="day" value="Tuesday">
                            <label for="weekday">Tuesday</label>
                        </div>
                        <div class="col-6">
                            <input type="checkbox" id="" name="day" value="Wednesday">
                            <label for="all days">Wednesday</label>
                        </div>
                        <div class="col-6">
                            <input type="checkbox" id="" name="day" value="Thursday">
                            <label for="selected days">Thursday</label>
                        </div>
                        <div class="col-6">
                            <input type="checkbox" id="" name="day" value="Friday">
                            <label for="selected days">Friday</label>
                        </div>
                        
                    </div>
                    <div class="row">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="float:right">Cancel</button>
                            <button type="button" class="btn btn-purp" style="float:right;margin-left:50px !important">Save</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div id="calendar"></div>
@endsection

@section('javascript')
    <script type="text/javascript">
    
        $(document).ready(function() {
            const language = "{{ (session()->get("language")) }}";
            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                themeSystem: 'bootstrap',
                locale: language,
                dateClick: function(info) {
                    $('#eventModal').modal('show');
                }
            });
            calendar.render();
        });

        function addAvaHandler(){
            var add_ava=$(".ava-repeat").html();
            $(".multiple-ava").append(add_ava);
        }
        $("input[name='dateselect']").on('change',function(){
            if($('#weekday-input').prop('checked')===true)
            {
                $(".weekday-list").show();
            }
            if($('#weekday-input').prop('checked')===false){
                $(".weekday-list").hide();
            }
        });
    </script>
@endsection
