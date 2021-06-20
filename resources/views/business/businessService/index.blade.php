@extends('layouts.app')
@section('title', env('APP_NAME').' - '.trans('messages.services'))

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-fw fa-users"></i> @lang('messages.services')
        </h1>
        <div class="btn-group">
            <a href="{{ route('business.businessService.create') }}" class="d-none d-sm-inline-block btn btn-purp shadow-sm">
                <i class="fas fa-plus-circle fa-sm fa-fw"></i> @lang('messages.service')
            </a>
        </div>
    </div>
    <!-- End Page Heading -->

    <!-- Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-hover" id="datatable">
                    <thead>
                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.status')</th>
                        <th>@lang('messages.created_at')</th>
                        <td>@lang('messages.actions')</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($businessServices as $businessService)
                        <tr class="text-center">
                            <td>{{ $businessService->name }}</td>
                            <td>
                                @if($businessService->status == App\Enums\StatusType::ACTIVE)
                                    <span class="badge badge-primary">@lang('status.'.$businessService->status)</span>
                                @else
                                    <span class="badge badge-danger">@lang('status.'.$businessService->status)</span>
                                @endif
                            </td>
                            <td>{{ $businessService->created_at }}</td>
                            <td>
                                <div class="btn-group btn-block">
                                    <a href="{{ route('business.businessService.edit', $businessService->id) }}" class="btn btn-purp" title="@lang('messages.edit')">
                                        <i class="fa fa-edit fa-fw"></i> @lang('messages.edit')
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- End Table -->
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $("#datatable").dataTable();
        });
    </script>
@endsection
