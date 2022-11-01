@extends('admin.layouts.master')

@section('title', 'Edit user')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Edit user</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">List users</a></li>
                <li class="breadcrumb-item active">Edit user</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit user</h3>
                </div>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <img src="{{$user->image?->url ?? env("APP_URL") . "/profile/" . ($user->sex == 0 ? "male":"female") . "-" .(( $user->id % 6 )  + 1). ".png"}}" style="border-radius:50%" height="64" width="64">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>full name</label>
                                <input type="text" value="{{ old('name', $user->name) }}" name="name"
                                    class="form-control @error('name') is-invalid @enderror">
                            </div>

                            <div class="form-group col-lg-3">
                                <label>sex</label>
                                <select name="sex" class="form-control">
                                    @foreach (config('global.sex') as $key => $sex)
                                        <option value="{{ $key}}"
                                            @if (old('sex', $user->sex) == $key ) selected @endif>{{ $sex }}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="form-group col-lg-3">
                                <label>phone</label>
                                <input type="text" value="{{ old('phone', $user->phone) }}" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror">
                            </div>

                            <div class="w-100"></div>
                            <div class="form-group col-lg-4">
                                <label>password</label>

                                <input placeholder="if you want to change it" type="text" name="password"
                                    class="form-control @error('password') is-invalid @enderror">

                            </div>
                            <div class="form-group col-lg-3">
                                <label>active</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                        id="exampleCheck2" @if (old('is_active', $user->is_active)) checked @endif>
                                    <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>
                    </div>
                    <!-- /.card-body -->

                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/simplebox/simplebox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/miladi-datepicker/datepicker.min.css') }}">
@endpush
