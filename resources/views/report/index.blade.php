@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    @if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @foreach ($inits as $init)
    <div class="card border-grey shadow mb-3">
        <div class="card-body py-3 px-4">
            <div class="row">
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="mb-2">
                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                                    {{ $init->activity->status }}
                                </p>
                                <p class="fw-bolder" style="font-size: 18px">{{ $init->activity->objective }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-2">
                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target</p>
                                @if ($init->activity->target_type == 'Precentage')
                                <p class="fw-bold">{{ $init->activity->target }} %</p>
                                @elseif ($init->activity->target_type == 'Rupiah')
                                <p class="fw-bold rupiah">Rp. {{ number_format($init->activity->target, 0, ',', '.') }}
                                </p>
                                @else
                                <p class="fw-bold">{{ $init->activity->target }} %</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="mb-2">
                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                                    Initiatives
                                </p>
                                <p class="fw-bold">{{ $init->initiative }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-2">
                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target</p>
                                @if ($init->target_type == 'Precentage')
                                <p class="fw-bold">{{ $init->target }} %</p>
                                @elseif ($init->target_type == 'Rupiah')
                                <p class="fw-bold">Rp. {{ number_format($init->target, 0, ',', '.') }}</p>
                                @else
                                <p class="fw-bold">{{ $init->target }} %</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="pb-1 font-11">
                        <div class="row g-3">
                            <div class="col-sm-1">
                                <div class="row">
                                    <div class="col px-1 text-center text-white bg-secondary border">YTD</div>
                                    <div class="col px-1 text-center border">Plan</div>
                                    <div class="col px-2 text-center border">Act</div>
                                    <div class="col px-3 text-center border">%</div>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <div class="d-flex">
                                    @foreach ($init->reports as $report)
                                    <div class="col border">
                                        <div class="col px-2 text-white bg-secondary border text-center">
                                            {{ $report->month }}</div>
                                        <div class="col px-2 border text-end planning">{{ $report->plan }} %</div>
                                        <div class="col px-2 border text-end aktual">{{ $report->actual }} %</div>
                                        <div class="col px-2 border text-end hasil-presentase"></div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div id="chart_{{ $loop->index }}"></div>
                    </div>
                    <div class="text-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#assignModal_{{ $init->id }}">
                            Create
                        </button>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="assignModal_{{ $init->id }}" tabindex="-1"
                        aria-labelledby="assignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('report.store') }}" method="post">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="assignModalLabel">Assign Performance Report
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="initiative_id" value="{{ $init->id }}">
                                        <input type="hidden" name="last_month"
                                            value="{{ optional($init->reports->last())->month }}">
                                        <div class="mb-2">
                                            <label for="month" class="form-label">Month<span
                                                    style="color: red;">*</span></label>
                                            <select class="form-select" aria-label="Default select example" id="month"
                                                name="month">
                                                <option selected>Select Month</option>
                                                <option value="Jan">January</option>
                                                <option value="Feb">February</option>
                                                <option value="Mar">March</option>
                                                <option value="Apr">April</option>
                                                <option value="Mei">Mei</option>
                                                <option value="Jun">June</option>
                                                <option value="Jul">July</option>
                                                <option value="Aug">August</option>
                                                <option value="Sep">September</option>
                                                <option value="Oct">October</option>
                                                <option value="Nov">November</option>
                                                <option value="Dec">December</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="plan" class="form-label">Planning<span
                                                    style="color: red;">*</span></label>
                                            <input type="number" class="form-control" id="plan" name="plan"
                                                aria-describedby="inputExplain" required>
                                            <div id="inputExplain" class="form-text">Number input only, example: 20.
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="actual" class="form-label">Actual Progress<span
                                                    style="color: red;">*</span></label>
                                            <input type="number" class="form-control" id="actual" name="actual"
                                                aria-describedby="inputExplain" required>
                                            <div id="inputExplain" class="form-text">Number input only, example: 20.
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="result_desc" class="form-label">Result Description<span
                                                    style="color: red;">*</span></label>
                                            <textarea class="form-control" id="result_desc" name="result_desc"
                                                aria-describedby="textareaExplain" required></textarea>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="w-50 pe-1">
                                                <label for="problem_identification" class="form-label">Problem
                                                    Identification</label>
                                                <textarea class="form-control" id="problem_identification"
                                                    name="problem_identification"
                                                    aria-describedby="textareaExplain"></textarea>
                                            </div>
                                            <div class="w-50 ps-1">
                                                <label for="corrective_action" class="form-label">Corrective
                                                    Action</label>
                                                <textarea class="form-control" id="corrective_action"
                                                    name="corrective_action"
                                                    aria-describedby="textareaExplain"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection