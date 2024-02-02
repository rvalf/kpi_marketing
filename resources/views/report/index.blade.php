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

    @if(session('error'))
    <div class="alert alert-danger mb-3">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success mb-3">
        {{ session('success') }}
    </div>
    @endif

    @if ($inits->isEmpty())
    <div class="alert alert-warning mb-3">
        Sorry, you have no assignments to report. Please contact the Manager to receive the assignment!
    </div>
    @endif

    @foreach ($inits as $init)
    <div class="card border-grey shadow mb-3">
        <div class="card-body py-3 px-4">
            @php
            $lastReport = optional($init->reports->last());
            $lastReportMonth = $lastReport->created_at ? $lastReport->created_at->format('M') : null;
            $currentMonth = now()->format('M');
            $currentDay = now()->day;
            @endphp

            @if ($currentDay > 15 && ($lastReportMonth === null))
            <div class="alert alert-warning mb-3">
                <i class="ti ti-info-circle pe-2"></i>Warning! You haven't made a report this month, add it immediately
                before the deadline on the 25th.
            </div>
            @elseif ($currentDay > 15 && ($lastReportMonth !== $currentMonth))
            <div class="alert alert-warning mb-3">
                <i class="ti ti-info-circle pe-2"></i>Warning! You haven't made a report this month, add it immediately
                before the deadline on the 25th.
            </div>
            @elseif ($currentDay > 25 && ($lastReportMonth === null))
            <div class="alert alert-warning mb-3">
                <i class="ti ti-alert-triangle pe-2"></i>Danger! The report deadline has passed. Please submit your
                report as soon as possible.
            </div>
            @elseif ($currentDay > 25 && ($lastReportMonth !== $currentMonth))
            <div class="alert alert-warning mb-3">
                <i class="ti ti-alert-triangle pe-2"></i>Danger! The report deadline has passed. Please submit your
                report as soon as possible.
            </div>
            @endif
            <div class="row">
                <div class="col-sm-5">
                    <div class="row border-bottom border-3">
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
                    <div class="row mt-3 border-bottom border-3">
                        <div class="col-sm-8">
                            <div class="mb-2">
                                <p class="text-secondary fw-bolder mb-1" style="font-size: 11px">
                                    Initiatives
                                </p>
                                <p class="fw-bolder">{{ $init->initiative }}</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-2">
                                <p class="text-secondary fw-bolder mb-1" style="font-size: 11px">Target</p>
                                @if ($init->target_type == 'Precentage')
                                <p class="fw-bold">{{ $init->target }} %</p>
                                @elseif ($init->target_type == 'Rupiah')
                                <p class="fw-bold formattedValue">{{ $init->target }}</p>
                                @else
                                <p class="fw-bold">{{ $init->target }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 progres">
                        @if ($init->reports()->exists())
                        @if($init->reports->last()->actual == 100)
                        <div class="d-flex">
                            <p class="badge bg-success rounded-3 fw-semibold m-0">Complete</p>
                            <h4 class="fw-semibold m-0 ps-3">{{ $init->reports->last()->actual }}%</h4>
                        </div>
                        <div class="progress mt-3" role="progressbar" aria-label="Success example"
                            aria-valuenow="{{ $init->reports->last()->actual }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-success" style="width: {{ $init->reports->last()->actual }}%">
                                {{ $init->reports->last()->actual }}%
                            </div>
                        </div>
                        @else
                        @if ($init->target_type != 'Precentage')
                        @php
                        $lastReportActual = $init->reports->last()->actual;
                        $currentProgres = ($lastReportActual/$init->target) * 100;
                        @endphp
                        <div class="d-flex">
                            <p class="badge bg-secondary rounded-3 fw-semibold m-0">On progress</p>
                            <h4 class="fw-semibold m-0 ps-3">{{ $currentProgres }} %</h4>
                        </div>
                        <div class="progress mt-3" role="progressbar" aria-label="Success example"
                            aria-valuenow="{{ $currentProgres }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-secondary" style="width: {{ $currentProgres }}%">
                                {{ $currentProgres }} %
                            </div>
                        </div>
                        @else
                        <div class="d-flex">
                            <p class="badge bg-secondary rounded-3 fw-semibold m-0">On progress</p>
                            <h4 class="fw-semibold m-0 ps-3">{{ $init->reports->last()->actual }}%</h4>
                        </div>
                        <div class="progress mt-3" role="progressbar" aria-label="Success example"
                            aria-valuenow="{{ $init->reports->last()->actual }}" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-secondary" style="width: {{ $init->reports->last()->actual }}%">
                                {{ $init->reports->last()->actual }}%
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="mt-3">
                            <p class="m-0" style="font-size:11px">Result on {{ $init->reports->last()->month }} :</p>
                            <p class="m-0">{{ $init->reports->last()->result_desc }}</p>
                        </div>
                        @else
                        <p class="badge bg-danger rounded-3 fw-semibold m-0">Not yet started</p>
                        @endif
                    </div>
                    <div class="mt-4">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                            data-bs-target="#assignModal_{{ $init->id }}">
                            Create New Report
                        </button>
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
                                    <a href="" class="text-dark report-link" data-bs-toggle="modal"
                                        data-bs-target="#reportModal_{{ $report->id }}">
                                        <div class="col border">
                                            <div class="col px-2 text-white bg-secondary border text-center">
                                                {{ $report->month }}</div>
                                            @if ($init->target_type != 'Precentage')
                                            <div class="formattedValue col px-2 border text-end planning">
                                                {{ $report->plan }}</div>
                                            <div class="formattedValue col px-2 border text-end aktual">
                                                {{ $report->actual }}</div>
                                            @else
                                            <div class="col px-2 border text-end planning">{{ $report->plan }} %</div>
                                            <div class="col px-2 border text-end aktual">{{ $report->actual }} %</div>
                                            @endif
                                            <div class="col px-2 border text-end hasil-presentase"></div>
                                        </div>
                                    </a>
                                    <!-- Show Detail Report Modal -->
                                    <div class="modal fade" id="reportModal_{{ $report->id }}" tabindex="-1"
                                        aria-labelledby="reportModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content px-3">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="reportModalLabel">Report Detail
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3 px-3">
                                                        <p class="m-0 text-primary" style="font-size:11px">Result
                                                            Description :</p>
                                                        <p class="m-0 fw-bold">{{ $report->result_desc }}</p>
                                                    </div>
                                                    <div class="mb-3 px-3">
                                                        <p class="m-0 text-primary" style="font-size:11px">Problem
                                                            Identification :
                                                        </p>
                                                        <p class="m-0 fw-bold">{{ $report->problem_identification }}</p>
                                                    </div>
                                                    <div class="mb-3 px-3">
                                                        <p class="m-0 text-primary" style="font-size:11px">Corrective
                                                            Action :</p>
                                                        <p class="m-0 fw-bold">{{ $report->corrective_action }}</p>
                                                    </div>
                                                    <div class="mb-3 px-3">
                                                        @if ($report->evidence_file == null)
                                                        <p class="mb-1 text-primary" style="font-size:11px">Evidence
                                                            File :</p>
                                                        <p class="m-0 fw-bold">-</p>
                                                        @else
                                                        <p class="mb-1 text-primary" style="font-size:11px">Evidence
                                                            File :</p>
                                                        <p class="mb-1 fw-bold">{{ $report->evidence_file }}</p>
                                                        <form
                                                            action="{{ route('report.download', ['file' => $report->evidence_file]) }}"
                                                            method="GET">
                                                            <button class="btn btn-sm btn-primary"
                                                                type="submit">Download</button>
                                                        </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div
                                                        class="d-flex justify-content-between align-items-center w-100">
                                                        <div class="d-flex">
                                                            <div>
                                                                <p class="m-0" style="font-size:11px">This report was
                                                                    created by :</p>
                                                                <p class="m-0 fw-bold">{{ $report->user->fullname }}
                                                                    ({{ $report->user->status }})</p>
                                                            </div>
                                                            <div class="ps-5">
                                                                <p class="m-0" style="font-size:11px">submitted on <span
                                                                        class="text-danger">{{ $report->created_at->format('d') > 25 ? '(overdue report)' : '' }}</span>
                                                                    :</p>
                                                                <p class="m-0 fw-bold">
                                                                    {{ $report->created_at->format('d M Y H:i:s') }}</p>
                                                            </div>
                                                        </div>
                                                        <form
                                                            action="{{ route('report.destroy', ['id' => $report->id]) }}"
                                                            method="post"
                                                            onsubmit="return confirm('Are you sure you want to delete this report?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="ti ti-trash-x"></i> Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div id="chart_{{ $loop->index }}"></div>
                    </div>

                    <!-- Create New Report Modal -->
                    <div class="modal fade" id="assignModal_{{ $init->id }}" tabindex="-1"
                        aria-labelledby="assignModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('report.store', ['initiative_id' => $init->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="assignModalLabel">Assign Performance Report
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="initiative_id" value="{{ $init->id }}">
                                        <div class="mb-2">
                                            <label for="month" class="form-label">Month<span
                                                    style="color: red;">*</span></label>
                                            <select class="form-select" aria-label="Default select example" id="month"
                                                name="month" required>
                                                <option value="">Select Month</option>
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
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="w-50 pe-1">
                                                <label for="plan" class="form-label">Planning<span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="plan" name="plan"
                                                        aria-describedby="inputExplain" required min="1"><span
                                                        class="input-group-text">%</span>
                                                </div>
                                                <div id="inputExplain" class="form-text">Number input only, example: 20.
                                                </div>
                                            </div>
                                            <div class="w-50 ps-1">
                                                <label for="actual" class="form-label">Actual Progress<span
                                                        style="color: red;">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="actual" name="actual"
                                                        aria-describedby="inputExplain" required min="1"><span
                                                        class="input-group-text">%</span>
                                                </div>
                                                <div id="inputExplain" class="form-text">Number input only, example: 20.
                                                </div>
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
                                                    Identification<span style="color: red;">*</span></label>
                                                <textarea class="form-control" id="problem_identification"
                                                    name="problem_identification" aria-describedby="textareaExplain"
                                                    required></textarea>
                                            </div>
                                            <div class="w-50 ps-1">
                                                <label for="corrective_action" class="form-label">Corrective
                                                    Action <span style="color: red;">*</span></label>
                                                <textarea class="form-control" id="corrective_action"
                                                    name="corrective_action" aria-describedby="textareaExplain"
                                                    required></textarea>
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <label for="file" class="form-label">Evidence FIle</label>
                                            <input type="file" name="file" id="file"
                                                class="form-control form-control-sm mb-2">
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