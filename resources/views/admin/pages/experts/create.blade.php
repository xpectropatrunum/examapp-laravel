@extends('admin.layouts.master')

@section('title', 'create new expert')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">create new expert</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.experts.index') }}">all experts</a></li>
                <li class="breadcrumb-item active">create new expert</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-basic-tab" data-toggle="pill"
                               href="#custom-basic-home" role="tab" aria-controls="custom-basic-home"
                               aria-selected="true">basic info</a>
                        </li>
                     
                    </ul>
                </div>

                <form action="{{ route('admin.experts.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf



                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                                 aria-labelledby="custom-tabs-basic-tab">
                                 <div class="row">
                                   

                                    <div class="form-group col-lg-5">
                                        <label>name</label>
                                        <input type="text" value="{{ old('name') }}" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="نام" required>
                                    </div>

                                        
                                    <div class="form-group col-lg-5">
                                        <label>phone</label>
                                        <input type="text" value="{{ old('phone') }}" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror" placeholder="09123456789" required>
                                    </div>
                                   
                                   
                
                                    <div class="form-group col-lg-12">
                                        <label>users</label>
                                        <select name="users[]" class="form-control select2" multiple>
                                            <option></option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label>password</label>
        
                                        <input type="text" name="password"
                                            class="form-control @error('password') is-invalid @enderror">
        
                                    </div>
                
                                    <div class="form-group col-lg-5">
                                        <label>active</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" value="1" id="exampleCheck2" @if(old('is_active')) checked @endif>
                                            <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                        </div>
                                    </div>

                                    
                           
                
                             
                                 </div>
                              
                                    
                                   
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                    </div>




               
                </form>
            </div>
        </div>
    </div>
@endsection

@push('admin_css')
   
    <link rel="stylesheet" href="{{ asset('admin-panel/libs/colorpicker/colorpicker.min.css') }}">
@endpush

@push('admin_js')
   
    <script src="{{ asset('admin-panel/libs/colorpicker/colorpicker.min.js') }}"></script>
    <script>
        $(function() {
            $('.color-picker').colorpicker();

            var counter = 0;
            $(".btn-plus").on("click", function() {
                var html = $(".template-tag-warning").html();

                html = html.replace(/{ID}/g, counter++);

                $(".table-tag-warning tbody").append(html);
            });

            $(document).on("click", ".btn-remove-tag", function() {
                $(this).closest("tr").fadeOut(function() {
                    $(this).remove();
                });
            });

            $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled', true);
            $('#enable-content-warning').on('click', function() {
                if ($(this).is(':checked')) {
                    $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled',
                        false);
                    $('.warning-items').slideDown();
                    CKEDITOR.instances['content_warning[description]'].setReadOnly(false);
                } else {
                    $('.warning-items input,.warning-items textarea,.warning-items select').prop('disabled',
                        true);
                    $('.warning-items').slideUp();
                    CKEDITOR.instances['content_warning[description]'].setReadOnly(true);
                }
            });
        });
    </script>
@endpush
