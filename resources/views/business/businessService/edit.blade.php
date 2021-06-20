@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.edit').' '.trans('messages.service'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.edit') @lang('messages.service') - {{ $businessService->name }}
        </h1>
    </div>
    <!-- End Page Heading -->

    <form action="{{ route('business.businessService.update', $businessService->id) }}" method="post" autocomplete="off" id="form" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('business.businessService.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-purp float-right">
                            <i class="fa fa-fw fa-save"></i> @lang('messages.save') @lang('messages.service')
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">@lang('messages.name') *</label>
                            <input type="text" id="name" name="name" required autofocus maxlength="255" class="form-control" value="{{ old('name') ?? $businessService->name }}" placeholder="@lang('messages.name')...">
                        </div>
                        <div class="form-group">
                            <label for="description">@lang('messages.description') *</label>
                            <input type="text" id="description" name="description" maxlength="500" required class="form-control" value="{{ old('description') ?? $businessService->description }}" placeholder="@lang('messages.description')...">
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="price">@lang('messages.price')</label>
                                <input type="number" id="price" name="price" class="form-control" required value="{{ old('price') ?? $businessService->price ?? 0 }}" min="0" placeholder="@lang('messages.price')..." />
                            </div>
                            <div class="col-6">
                                <label for="currency">@lang('messages.currency')</label>
                                <select id="currency" name="currency" class="form-control" required style="width: 100%;">
                                    <option value="" disabled selected hidden>@lang('messages.chooseItem')</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency }}" @if($currency == old('$currency') || $currency == $businessService->currency) selected @endif>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code">@lang('messages.code')</label>
                            <input type="text" id="code" name="code" maxlength="10" class="form-control" required value="{{ old('code') ?? $businessService->code }}" placeholder="@lang('messages.code')...">
                        </div>
                        <div class="form-group">
                            <label for="status">@lang('messages.status') *</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="" disabled selected hidden>@lang('messages.chooseItem')</option>
                                @foreach($statusTypes as $status)
                                    <option value="{{ $status }}" @if(old('status') == $status || $businessService->status == $status) selected @endif>@lang('status.'.$status)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="staff_members">@lang('messages.staffMembers')</label>
                                <select id="staff_members" name="staff_members[]" class="form-control" required multiple style="width: 100%">
                                    @foreach($staffMembers as $staffMember)
                                        <option value="{{ $staffMember->id }}" @if(in_array($staffMember->id, $selectedStaffMembers)) selected @endif>{{ $staffMember->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="round_robin">@lang('messages.roundRobin')</label>
                                <select id="round_robin" name="round_robin" class="form-control" required>
                                    <option value="yes" @if($businessService->round_robin =="yes" || old('round_robin') == 'yes') selected @endif>@lang('messages.yes')</option>
                                    <option value="no" @if($businessService->round_robin =="no" || old('round_robin') == 'no') selected @endif>@lang('messages.no')</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-6">
                            <label for="service_category_id">@lang('messages.serviceCategory')</label>
                            <select id="service_category_id" name="service_category_id" class="form-control" style="width: 100%;" >
                                <option value="" selected>@lang('messages.none')</option>
                                @foreach($serviceCategories as $serviceCategory)
                                    <option value="{{ $serviceCategory->id }}" @if($serviceCategory->id == $businessService->service_category_id || $serviceCategory->id == old("service_category_id")) selected @endif>{{ $serviceCategory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                            <div class="col-6">
                                <label for="create_category">New Category?</label>
                                <a id="create_category" id="create_cateory" href="{{ route('business.businessServiceCategory.create') }}" class="btn btn-purp">@lang('messages.create') New Category</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="logo">@lang('messages.image')</label>
                            <button type="button" id="btnImage" class="btn btn-purp btn-block">
                                <i class="fa fa-picture-o fa-fw"></i> @lang('messages.add') @lang('messages.image')
                            </button>
                            <input type="file" id="image" name="image" accept="image/*" style="display: none;">
                            <br>
                            @if(!empty($businessService->image_url))
                                <img src="{{ $businessService->image_url }}" id="preview" class="img-fluid img-thumbnail" alt="Add image" />
                            @else
                                <img src="{{ asset('images/addimage.png') }}" id="preview" class="img-fluid img-thumbnail" alt="Add image" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            @lang('messages.booking') @lang('messages.form') for {{ $businessService->name }}
        </h1>
    </div>

    <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('business.businessService.index') }}" class="btn btn-warning">
                            <i class="fa fa-fw fa-arrow-circle-left"></i> @lang('messages.cancel')
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('business.businessServiceSignupForm.edit', $signupForm->id) }}" class="btn btn-purp float-right">
                            <i class="fa fa-fw fa-edit"></i> @lang('messages.edit') @lang('messages.form')
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                @foreach($signupForm->fields as $field)
                <div class="row border-bottom">    
                    <div class="col-md-6">
                        <div class="form-group">
                            <p for="{{ $field->description }}">{{ $field->description }}</p>
                            @if($field->type == 'textarea')
                                <textarea name="{{ $field->description }}" placeholder="{{ $field->description }}" width="100%" rows=3>
                                </textarea> 
                            @else
                            @foreach(explode(",",$field->options) as $option)
                            @lang($option =str_replace(array( '[', '"',']'),'', $option))
                            <!-- <label for="{{$option}}">{{$option}}</label> -->
                            <input type="@lang('fieldTypes.'.$field->type)" name="{{$field->description }}"  class="form-control"  placeholder="{{$field->description }}..." style="width:auto;height:auto;display:inline-block">
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                    <form action="{{ route('business.businessServiceSignupForm.deleteField', $field->id) }}" method="post" id="formDeleteField-{{ $field->id }}">
                    @csrf
                    @method('DELETE')
                        <div class="btn-group btn-block">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary" onclick="openModal('{{ $field }}')">
                                    <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger" onclick="deleteField({{ $field->id }})">
                                    <i class="fa fa-trash fa-fw"></i> @lang('messages.delete')
                                </button>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
                @endforeach


                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn" id="btnModalField">
                            <i class="fas fa-plus-circle fa-sm fa-fw"></i> @lang('messages.add') Questions
                        </button>
                    </div>
                </div>

    <form action="{{ route('business.businessServiceSignupForm.field') }}" autocomplete="off" method="post" id="formField">
        @csrf
        <input type="hidden" id="fieldMethod" name="fieldMethod" value="create" />
        <input type="hidden" id="signup_form_id" name="signup_form_id" value="{{ $signupForm->id }}" />
        <input type="hidden" id="business_service_id" name="business_service_id" value="{{ $businessService->id }}" />
        <input type="hidden" id="business_service_signup_form_field_id" name="business_service_signup_form_field_id" value="">
        <!-- The Modal -->
        <div class="modal fade" id="modalField">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalFieldTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="description">@lang('messages.description')</label>
                            <input type="text" id="description" name="description" class="form-control" required min="255" value="" placeholder="@lang('messages.description')...">
                        </div>
                        <div class="form-group">
                            <label for="type">@lang('messages.type')</label>
                            <select id="type" name="type" class="form-control" required style="width: 100%;">
                                <option value="" disabled selected hidden>@lang('messages.chooseItem')</option>
                                @foreach($fieldTypes as $fieldType)
                                    <option value="{{ $fieldType }}">@lang('fieldTypes.'.$fieldType)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" id="is_required" name="is_required" value="on" class="form-check-input">
                            <label for="is_required">@lang('messages.isRequired')?</label>
                        </div>
                        <div id="divFieldOptions" style="display: none;">
                            <hr>
                            <div id="inputFieldOptions"></div>
                            <div class="form-group">
                                <button type="button" class="btn btn-purp btn-block" id="btnAddFieldOption">
                                    @lang('messages.add') @lang('messages.option')
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="btnCloseModalField">@lang('messages.close')</button>
                        <button type="submit" class="btn btn-success">@lang('messages.save')</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    

   

@endsection

@section('javascript')
    <script>
        /* linking service category in dropdown
        document.getElementByID("service_category_id").onchange = function () {
            if(this.selectedIndex!==0)
            {
                if(this.value == "create")
                {
                    window.location.href = "google.com";
                }
            }
            
        }*/
              

        $(document).ready(function(){
            $("#form").submit(function(){
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#currency").select2({
                theme: 'bootstrap4'
            });

            $("#service_category_id").select2({
                theme: 'bootstrap4'
            });

            $("#staff_members").select2({
                theme: 'bootstrap4',
                placeholder: "@lang('messages.chooseItem')"
            });

            $("#btnImage").click(function(){
                document.getElementById("image").click();
            });

            $("#preview").click(function(){
                document.getElementById("image").click();
            });

            $("#image").change(function(){
                let file    = document.getElementById('image').files[0];
                let preview = document.getElementById('preview');
                let reader  = new FileReader();

                reader.onloadend = function() {
                    preview.src = reader.result;
                };

                if (file) reader.readAsDataURL(file);
            });
        });

        //Modal

        function openModal(item = null) {
            item = JSON.parse(item);

            if (item == null)
            {
                $("#modalFieldTitle").text("@lang('messages.create') @lang('messages.field')");
                closeModal();
            }
            else
            {
                $("#modalFieldTitle").text("@lang('messages.edit') @lang('messages.field')");
                document.getElementById("description").value = item.description;
                $("#type").val(item.type).trigger("change");
                $("#is_required").val(item.is_required).trigger("change");
                document.getElementById("fieldMethod").value = "update";
                var options = ['checkbox', 'select', 'radio'];
                document.getElementById("divFieldOptions").style.display = (options.includes(item.type)) ? "block": "none";
                document.getElementById("business_service_signup_form_field_id").value = item.id;

                if (item.options_fields != null) {
                    var html = ``;
                    item.options_fields.forEach(option => {
                        let id = makeId(5);
                        html += `<div class="form-group row" id="${id}">`;
                        html += `<div class="col-8">`;
                        html += `<input type="text" name="options[]" value="${option}" class="form-control" required placeholder="@lang('messages.option')..." />`;
                        html += `</div>`;
                        html += `<div class="col-4">`;
                        html += `<button type="button" class="btn btn-danger btn-block" onclick="deleteFieldOption('${id}')"><i class="fa fa-trash fa-fw"></i></button>`;
                        html += `</div>`;
                        html += `</div>`;
                    });
                }

                $("#inputFieldOptions").append(html);
            }

            $("#modalField").modal({
                backdrop: 'static'
            })
        }

        function closeModal()
        {
            document.getElementById("description").value = "";
            $("#type").val("").trigger("change");
            $("#is_required").val("").trigger("change");
            document.getElementById("fieldMethod").value = "create";
            document.getElementById("divFieldOptions").style.display = "none";
            document.getElementById("inputFieldOptions").innerHTML = "";
            document.getElementById("business_service_signup_form_field_id").value = "";
        }

        function deleteField(id)
        {
            Swal
                .fire({
                    title: "@lang('messages.confirmItemDeletion')",
                    icon: 'question',
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    confirmButtonText: "@lang('messages.yes')",
                    cancelButtonText: "No",
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: "@lang('messages.pleaseWait')",
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading();
                                document.getElementById(`formDeleteField-${id}`).submit();
                            }
                        });
                    }
                });
        }

        function deleteFieldOption(id)
        {
            $("#"+id).remove();
        }

        function makeId(length)
        {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return `field-option-${result}`;
        }

        $(document).ready(function(){
            $("#form").submit(function(){
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#formField").submit(function(){
                Swal.fire({
                    title: "@lang('messages.pleaseWait')",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        Swal.showLoading();
                    }
                });
            });

            $("#tableQuestions").dataTable();

            $("#type").select2({
                theme: 'bootstrap4'
            });

            $("#btnModalField").click(function(){
                openModal();
            });

            $("#btnCloseModalField").click(function(){
                closeModal();
            });

            $('#type').change(function(){
                var options = ['checkbox', 'select', 'radio'];
                document.getElementById("divFieldOptions").style.display = (options.includes(this.value)) ? "block": "none";
            });
            

            $("#btnAddFieldOption").click(function(){
                const id = makeId(5);
                var html = `<div class="form-group row" id="${id}">`;
                html += `<div class="col-8">`;
                html += `<input type="text" name="options[]" value="" class="form-control" required placeholder="@lang('messages.option')..." />`;
                html += `</div>`;
                html += `<div class="col-4">`;
                html += `<button type="button" class="btn btn-danger btn-block" onclick="deleteFieldOption('${id}')"><i class="fa fa-trash fa-fw"></i></button>`;
                html += `</div>`;
                html += `</div>`;
                $("#inputFieldOptions").append(html);
            });
        });
    </script>
@endsection
