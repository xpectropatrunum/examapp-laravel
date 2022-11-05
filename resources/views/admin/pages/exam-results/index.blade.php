@extends('admin.layouts.master')

@section('title', 'exam results')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">exam results list</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb @if (app()->getLocale() == 'fa') float-sm-left @else float-sm-right @endif">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">dashboard</a></li>
                <li class="breadcrumb-item active">exam results</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Default box -->
            <div class="card">
                <div class="card-header d-flex align-items-center px-3">
                    <h3 class="card-title">exam results</h3>

                </div>
                <div class="card-body p-3">
                    <form class="frm-filter" action="{{ route('admin.exam-results.index') }}" type="post"
                        autocomplete="off">
                        @csrf

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="input-group input-group-sm" style="width: 70px;">
                                <select name="limit" class="custom-select">
                                    <option value="10" @if ($limit == 10) selected @endif>10</option>
                                    <option value="25" @if ($limit == 25) selected @endif>25</option>
                                    <option value="50" @if ($limit == 50) selected @endif>50</option>
                                    <option value="100" @if ($limit == 100) selected @endif>100</option>
                                    <option value="200" @if ($limit == 200) selected @endif>200</option>
                                </select>
                            </div>

                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="search" class="form-control"
                                    placeholder="{{ __('admin.search') }}..." value="{{ $search }}">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ 'User' }}</th>
                                    <th>{{ 'Exam' }}</th>
                                    <th>{{ 'Score' }}</th>
                                    <th>{{ __('admin.created_date') }}</th>
                                    <th>{{ __('admin.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        @if (auth()->guard("admin")->check())
                                        <td><a href="/admin/users/{{ $item->user->id }}/edit">{{ $item->user->name }}</a>
                                        </td>
                                        <td><a href="/admin/exams/{{ $item->exam->id }}/edit">{{ $item->exam->title }}</a>
                                        </td>
                                        @else
                                        <td>{{ $item->user->name }}
                                        </td>
                                        <td>{{ $item->exam->title }}
                                        </td>
                                        @endif
                                       
                                        @php
                                            $correct = 0;
                                            $false = 0;
                                            $b_item = $item->session;
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
                                        <td dir="ltr">{{ $percentage * 100 }}%</td>
                                        <td>{{ (new Shamsi())->jdate($item->created_at) }}</td>

                                        <td class="project-actions">
                                            <a class="btn btn-info btn-sm"
                                                href="{{ route('admin.exam-results.show', $item->id) }}">
                                                <i class="fas fa-eye"></i>
                                                Show
                                            </a>

                                       


                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cart-footer p-3 d-block d-md-flex justify-content-between align-items-center border-top">
                    {{ $reports->onEachSide(0)->links('admin.partials.pagination') }}

                    <p class="text-center mb-0">
                        {{ __('admin.display') . ' ' . $reports->firstItem() . ' ' . __('admin.to') . ' ' . $reports->lastItem() . ' ' . __('admin.from') . ' ' . $reports->total() . ' ' . __('admin.rows') }}
                    </p>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection

@push('admin_css')
@endpush

@push('admin_js')
    <script>
        $(function() {
            $('.changeStatus').on('change', function() {
                id = $(this).attr('data-id');

                if ($(this).is(':checked')) {
                    enable = 1;
                } else {
                    enable = 0;
                }

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'post',
                    data: {
                        'enable': enable,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        // $("#beforeAfterLoading").addClass("spinner-border");
                    },
                    complete: function() {
                        // $("#beforeAfterLoading").removeClass("spinner-border");
                    },
                    success: function(res) {
                        Toast.fire({
                            icon: 'success',
                            'title': 'Record status successfully changed'
                        })
                    }
                });
            });
        });
    </script>
@endpush
