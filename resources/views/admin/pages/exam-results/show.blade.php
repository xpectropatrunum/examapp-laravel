@extends('admin.layouts.master')

@section('title', ' exam report')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"> exam report</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.exams.index') }}">all exams</a></li>
                <li class="breadcrumb-item active"> exam report</li>
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
                                aria-selected="true">Result</a>
                        </li>


                    </ul>
                </div>




                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">


                        <div class="tab-pane fade show active" id="custom-basic-home" role="tabpanel"
                            aria-labelledby="custom-tabs-basic-tab">

                            <div class="row">
                                <h3 class="col-12">User</h3>

                                <div class="form-group col-lg-4">
                                    <label>name</label>
                                    <div> {{ $report->user->name }}</div>

                                </div>
                                <div class="form-group col-lg-4">
                                    <label>phone</label>
                                    <div> {{ $report->user->phone }}</div>
                                </div>
                                <div class="form-group col-lg-4">
                                    <label>sex</label>
                                    <div> {{ $report->user->sex ? 'male' : 'female' }}</div>
                                </div>
                                <hr style="
                                width: 100%;
                            ">

                                <h3 class="col-12 mt-3">Exam</h3>
                                <div class="form-group col-lg-3">
                                    <label>title</label>
                                    <div> {{ $report->exam->title }}</div>

                                </div>
                                <div class="form-group col-lg-3">
                                    <label>type</label>
                                    <div> {{ $report->exam->type }}</div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>question count</label>
                                    <div> {{ $report->exam->q_number }}</div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>time</label>
                                    <div> {{ $report->exam->q_time }} minutes</div>
                                </div>

                                @php
                                    $correct = 0;
                                    $false = 0;
                                    $b_item = $report->session;
                                    $keys = $b_item->exam->key->keys;
                                    $answers = $b_item->answers;
                                    foreach ($answers as $item_) {
                                        if ($keys[$item_->q - 1] == $item_->a) {
                                            $correct += 1;
                                        } else {
                                            $false += 1;
                                        }
                                    }
                                    
                                    $percentage = round(($correct * 3 - ($b_item->exam->neg_score ? $false : 0)) / ($b_item->exam->q_number * 3), 4);
                                    
                                @endphp


                                <hr style="
width: 100%;
">

                                <h3 class="col-12 mt-3">Result</h3>
                                <div class="form-group col-lg-3">
                                    <label>correct count</label>
                                    <div> {{ $correct }}</div>

                                </div>
                                <div class="form-group col-lg-3">
                                    <label>wrong count</label>
                                    <div> {{ $false }}</div>
                                </div>
                                <div class="form-group col-lg-3">
                                    <label>negative score?</label>
                                    <div> {{ $report->exam->neg_score ? 'Yes' : 'No' }}</div>
                                </div>


                                <div class="form-group col-lg-3">
                                    <label>score</label>
                                    <div> {{ $percentage * 100 }}%</div>
                                </div>








                            </div>



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
