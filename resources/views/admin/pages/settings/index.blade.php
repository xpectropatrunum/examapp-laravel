@extends('admin.layouts.master')

@section('title', __('admin.general_settings'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{ __('admin.general_settings') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if(app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('admin.general_settings') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
       
      

        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="m-0">User Dashboard Message </h5>
                </div>
                <form action="{{ route('admin.settings.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="type" value="message_template">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">message template</label>
                            <textarea name="msg" class="editor form-control" rows="5">{{ old('msg',$msg ?? '') }}</textarea>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">{{ __('admin.apply').' '.__('admin.changes') }}</button>
                    </div>
                </form>
            </div>
        </div>

     
       
    </div>
@endsection

@push('admin_css')

@endpush

@push('admin_js')

@endpush
