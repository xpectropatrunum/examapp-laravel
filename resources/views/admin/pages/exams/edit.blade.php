@extends('admin.layouts.master')

@section('title', 'edit exam')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">edit exam</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}">all exams</a></li>
                <li class="breadcrumb-item active">edit exam</li>
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
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-basic-tab" data-toggle="pill" href="#custom-questions"
                                role="tab" aria-controls="custom-basic-home" aria-selected="true">questions</a>
                        </li>

                    </ul>
                </div>




                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">


                        <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <form action="{{ route('admin.exams.update', $exam->id) }}" method="post"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="form-group col-lg-5">
                                        <label>image</label>
                                        <input type="file" value="{{ old('file') }}" name="file"
                                            class="d-block @error('file') is-invalid @enderror">
                                       
                                  
                                            <img src="{{$exam->image}}" width="150">
                                                
                                      
                                    </div>

                                    <div class="form-group col-lg-5">
                                        <label>title</label>
                                        <input type="text" value="{{ old('title', $exam->title) }}" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="مثلا: جمع بندی" required>
                                    </div>


                                    <div class="form-group col-lg-5">
                                        <label>type</label>
                                        <input type="text" value="{{ old('type', $exam->type) }}" name="type"
                                            class="form-control @error('type') is-invalid @enderror" placeholder="شیمی"
                                            required>
                                    </div>

                                    <div class="form-group col-lg-5">
                                        <label>question count</label>
                                        <input type="number" value="{{ old('q_number', $exam->q_number) }}" name="q_number"
                                            class="form-control @error('q_number') is-invalid @enderror" placeholder="20"
                                            required>
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label>time (in minutes)</label>
                                        <input type="number" value="{{ old('q_time', $exam->q_time) }}" name="q_time"
                                            class="form-control @error('q_time') is-invalid @enderror" placeholder="40"
                                            required>
                                    </div>

                                    <div class="form-group col-lg-10">
                                        <label>description</label>
                                        <textarea type="text" name="description" class="form-control">{{ old('description', $exam->description) }}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label>users</label>
                                        <select name="users[]" class="form-control select2" multiple>
                                            <option></option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}"
                                                    @if ($exam->users()->where('user_id', $user->id)->first()) selected @endif>
                                                    {{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>



                                    <div class="form-group col-lg-5">
                                        <label>active</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_active" class="form-check-input" value="1"
                                                id="exampleCheck2" @if (old('is_active', $exam->is_active)) checked @endif>
                                            <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                        </div>
                                    </div>


                                    <div class="form-group col-lg-5">
                                        <label>has negative score?</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="neg_score" class="form-check-input" value="1"
                                                id="exampleCheck2" @if (old('neg_score', $exam->neg_score)) checked @endif>
                                            <label class="form-check-label" for="exampleCheck2"> Yes</label>
                                        </div>
                                    </div>


                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>


                            </form>
                        </div>




                        <div class="tab-pane fade" id="custom-questions" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">
                            <form action="{{ route('admin.exams.save-question', $exam->id) }}" method="post"
                                enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label>upload pdf file</label>
                                        <input type="file" value="{{ old('file', $exam->file) }}" name="file"
                                            class="d-block @error('file') is-invalid @enderror" required>
                                            @if ($exam->file)
                                            <a href="{{$exam->file->url}}" target="_blank">See last uploaded file</a>
                                                
                                            @endif
                                    </div>


                                    <h5 class="col-12 mt-5">Keys</h5>
                                    @for ($i = 0; $i < $exam->q_number; $i++)
                                        <div class="form-group col-1">
                                            <label>{{$i+1}}</label>
                                            <input type="text" value="{{ old("keys.$i", $exam->key?->keys[$i]) }}"
                                                name="keys[]" class="form-control @error("keys.$i") is-invalid @enderror"
                                               required>
                                        </div>
                                    @endfor

                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('admin.update') }}</button>


                            </form>
                        </div>
                    </div>






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
