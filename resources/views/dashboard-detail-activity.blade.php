@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-4 shadow-sm">
            <h5 class="card-title fw-bolder">Score Board</h5>
            @foreach ($inits as $init)
            <div class="card border-grey shadow mb-3">
                <div class="card-body py-3 px-4">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="row border-bottom border-3">
                                <div class="col-sm-8">
                                    <div class="mb-2">
                                        <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                                            {{ $init->activity->status }}
                                        </p>
                                        <p class="fw-bold">
                                            {{ $init->activity->objective }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-2">
                                        <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target
                                        </p>
                                        @if ($init->activity->target_type == 'Precentage')
                                        <p class="fw-bold">{{ $init->activity->target }} %</p>
                                        @elseif ($init->activity->target_type == 'Rupiah')
                                        <p class="fw-bold rupiah">Rp.
                                            {{ number_format($init->activity->target, 0, ',', '.') }}
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
                                        <p class="fw-bolder" style="font-size: 18px">{{ $init->initiative }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-2">
                                        <p class="text-secondary fw-bolder mb-1" style="font-size: 11px">Target
                                        </p>
                                        @if ($init->target_type == 'Precentage')
                                        <p class="fw-bold">{{ $init->target }} %</p>
                                        @elseif ($init->target_type == 'Rupiah')
                                        <p class="fw-bold formattedValue">{{ $init->target }}
                                        </p>
                                        @else
                                        <p class="fw-bold">{{ $init->target }} %</p>
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
                                    aria-valuenow="{{ $init->reports->last()->actual }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ $init->reports->last()->actual }}%">
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
                                    aria-valuenow="{{ $init->reports->last()->actual }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                    <div class="progress-bar bg-secondary"
                                        style="width: {{ $init->reports->last()->actual }}%">
                                        {{ $init->reports->last()->actual }}%
                                    </div>
                                </div>
                                @endif
                                @endif
                                <div class="mt-3">
                                    <p class="m-0" style="font-size:11px">Result on
                                        {{ $init->reports->last()->month }} :</p>
                                    <p class="m-0">{{ $init->reports->last()->result_desc }}</p>
                                </div>
                                @else
                                <p class="badge bg-danger rounded-3 fw-semibold m-0">Not yet started</p>
                                @endif
                            </div>
                            <div class="mt-3">
                                <p class="m-0" style="font-size:11px">Person in charge (PIC) :</p>
                                <p class="m-0"><span class="fw-bold">{{ $init->user->fullname }}</span> (
                                    {{ $init->user->status }} )</p>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="pb-1 font-11">
                                <div class="row g-3">
                                    <div class="col-sm-1">
                                        <div class="row">
                                            <div class="col px-1 text-center text-white bg-secondary border">YTD
                                            </div>
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
                                                    <div class="col px-2 border text-end planning">
                                                        {{ $report->plan }} %</div>
                                                    <div class="col px-2 border text-end aktual">
                                                        {{ $report->actual }} %</div>
                                                    @endif
                                                    <div class="col px-2 border text-end hasil-presentase">
                                                    </div>
                                                </div>
                                            </a>
                                            <!-- Show Detail Report Modal -->
                                            <div class="modal fade" id="reportModal_{{ $report->id }}" tabindex="-1"
                                                aria-labelledby="reportModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content px-3">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="reportModalLabel">Report
                                                                Detail
                                                            </h1>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 px-3">
                                                                <p class="m-0 text-primary" style="font-size:11px">
                                                                    Result Description :</p>
                                                                <p class="m-0 fw-bold">{{ $report->result_desc }}</p>
                                                            </div>
                                                            <div class="mb-3 px-3">
                                                                <p class="m-0 text-primary" style="font-size:11px">
                                                                    Problem Identification :
                                                                </p>
                                                                <p class="m-0 fw-bold">
                                                                    {{ $report->problem_identification }}</p>
                                                            </div>
                                                            <div class="mb-3 px-3">
                                                                <p class="m-0 text-primary" style="font-size:11px">
                                                                    Corrective Action :</p>
                                                                <p class="m-0 fw-bold">{{ $report->corrective_action }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3 px-3">
                                                                @if ($report->evidence_file == null)
                                                                <p class="mb-1 text-primary" style="font-size:11px">
                                                                    Evidence File :</p>
                                                                <p class="m-0 fw-bold">-</p>
                                                                @else
                                                                <p class="mb-1 text-primary" style="font-size:11px">
                                                                    Evidence File :</p>
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
                                                                        <p class="m-0" style="font-size:11px">This
                                                                            report was created by :</p>
                                                                        <p class="m-0 fw-bold">
                                                                            {{ $report->user->fullname }}
                                                                            ({{ $report->user->status }})</p>
                                                                    </div>
                                                                    <div class="ps-5">
                                                                        <p class="m-0" style="font-size:11px">submitted
                                                                            on :</p>
                                                                        <p class="m-0 fw-bold">{{ $report->created_at }}
                                                                        </p>
                                                                    </div>
                                                                </div>
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
                                <div id="scoreboard_detail_actId">{{ $init->activity->id }}</div>
                                <div id="chartDashboard_{{ $loop->index }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection