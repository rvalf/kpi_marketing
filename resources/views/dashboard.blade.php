@extends($layout)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->divisi_id === 1)
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body p-4 shadow-sm">
                            <h5 class="card-title fw-bold">Current Activity Progress : <span
                                    class="ps-1 fw-bolder">{{ number_format($grandTotalProgres, 2) }} %</span></h5>
                            <div class="progress" role="progressbar" aria-label="Animated striped example"
                                aria-valuenow="{{ $grandTotalProgres }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                    style="width: {{ $grandTotalProgres }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body p-4 shadow-sm">
                            <p class="badge bg-primary mb-2 rounded-3 mb-3" style="font-size: 12px">Wildly Important
                                Goal</p>
                            <table class="table table-bordered table-sm">
                                @foreach ($actWIG as $activity)
                                <tr>
                                    <td style="width:50px; text-align:center;">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <p class="mb-1 fw-bold">{{ $activity->objective }}</p>
                                        <div class="progress" role="progressbar" aria-label="Success example"
                                            aria-valuenow="{{ $progresActWIG[$activity->id] }}" aria-valuemin="0"
                                            aria-valuemax="100" style="height: 10px">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ $progresActWIG[$activity->id] }}%;">
                                                {{ $progresActWIG[$activity->id] }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:140px;">
                                        @if ( $progresActWIG[$activity->id] == 100)
                                        <span class="round-8 bg-success rounded-circle me-1 d-inline-block"></span>
                                        Complete
                                        @elseif ( $progresActWIG[$activity->id] > 0)
                                        <span class="round-8 bg-secondary rounded-circle me-1 d-inline-block"></span>
                                        On progres
                                        @else
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        Not yet started
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            <p class="badge bg-warning mb-2 rounded-3 mb-3" style="font-size: 12px">Important
                                Goal</p>
                            <table class="table table-bordered table-sm">
                                @foreach ($actIG as $activity)
                                <tr>
                                    <td style="width:50px; text-align:center;">{{ $loop->index + 1 }}</td>
                                    <td>
                                        <p class="mb-1 fw-bold">{{ $activity->objective }}</p>
                                        <div class="progress" role="progressbar" aria-label="Success example"
                                            aria-valuenow="{{ $progresActIG[$activity->id] }}" aria-valuemin="0"
                                            aria-valuemax="100" style="height: 10px">
                                            <div class="progress-bar bg-primary"
                                                style="width: {{ $progresActIG[$activity->id] }}%;">
                                                {{ $progresActIG[$activity->id] }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width:140px;">
                                        @if ( $progresActIG[$activity->id] == 100)
                                        <span class="round-8 bg-success rounded-circle me-1 d-inline-block"></span>
                                        Complete
                                        @elseif ( $progresActIG[$activity->id] > 0)
                                        <span class="round-8 bg-secondary rounded-circle me-1 d-inline-block"></span>
                                        On progres
                                        @else
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        Not yet started
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body p-4 shadow-sm">
                            @foreach ($data as $item)
                            <div class="mb-3">
                                <h5 class="card-title fw-bolder">Dept. {{ $item['divisi_name'] }}</h5>
                                <div class="d-flex">
                                    <div class="text-center px-2 pe-4">
                                        <h1 class="fw-bold mb-1" style="font-size:45px">{{ $item['total_staff'] }}</h1>
                                        <p>Staff</p>
                                    </div>
                                    <div>
                                        <p class="mb-1">Total Task : {{ $item['total_task'] }}</p>
                                        <p class="m-0" style="font-size:12px">Uncomplete : {{ $item['uncomplete'] }}</p>
                                        <p class="m-0" style="font-size:12px">Complete : {{ $item['complete'] }}</p>
                                        <p class="m-0" style="font-size:12px">Progress : {{ $item['progress'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div id="deptTask_{{ $loop->index }}"></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body p-4 shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title fw-bolder">Score Board</h5>
                        <a href="{{ route('export.pdf') }}" class="btn btn-dark"> <i class="ti ti-file-export"></i> Export to PDF</a>
                    </div>
                    @foreach ($actWIG as $act)
                    <div class="card border-grey shadow mb-3">
                        <div class="card-body py-3 px-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="mb-2">
                                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                                                    {{ $act->status }}
                                                </p>
                                                <p class="fw-bolder" style="font-size: 18px">
                                                    {{ $act->objective }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 text-end">
                                            <div class="mb-2">
                                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Weight
                                                </p>
                                                <p class="fw-bold">{{ $act->weight }} %</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 text-end">
                                            <div class="mb-2">
                                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target
                                                </p>
                                                @if ($act->target_type == 'Precentage')
                                                <p class="fw-bold">{{ $act->target }} %</p>
                                                @elseif ($act->target_type == 'Rupiah')
                                                <p class="fw-bold rupiah">Rp.
                                                    {{ number_format($act->target, 0, ',', '.') }}
                                                </p>
                                                @else
                                                <p class="fw-bold">{{ $act->target }} %</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-end" style="width:25%">
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.detail', $act->id) }}"
                                                    class="btn btn-sm btn-primary">Scoreboard Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($progresActWIG[$act->id] != 0)
                                    <div class="progress" role="progressbar" aria-label="Success example"
                                        aria-valuenow="{{ $progresActWIG[$act->id] }}" aria-valuemin="0"
                                        aria-valuemax="100" style="height: 16px">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $progresActWIG[$act->id] }}%;">
                                            {{ $progresActWIG[$act->id] }}%
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    @if ($act->initiatives->isNotEmpty())
                                    <table class="table table-sm table-bordered table-hover mt-4">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="20">No</th>
                                                <th scope="col">Initiatives</th>
                                                <th scope="col" class="text-end">Target</th>
                                                <th scope="col" class="text-end">Actual</th>
                                                <th scope="col" class="text-end">Progres</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($act->initiatives as $init)
                                            <tr>
                                                <td class="text-center">{{ $loop->index+1 }}</td>
                                                <td>{{ $init->initiative }}</td>
                                                @if ($init->target_type == 'Precentage')
                                                <td class="text-end">{{ $init->target }} %</td>
                                                @elseif ($init->target_type == 'Rupiah')
                                                <td class="text-end formattedValue">{{ $init->target }}</td>
                                                @else
                                                <td class="text-end">{{ $init->target }}</td>
                                                @endif
                                                @if ($init->reports && $lastReport = $init->reports->last())
                                                @if ($init->target_type == 'Precentage')
                                                <td class="text-end">{{ $lastReport->actual }} %</td>
                                                @elseif ($init->target_type == 'Rupiah')
                                                <td class="text-end formattedValue">{{ $lastReport->actual }}</td>
                                                @else
                                                <td class="text-end">{{ $lastReport->actual }}</td>
                                                @endif
                                                <td class="text-end">{{ $lastReport->actual/$init->target * 100}} %</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="mx-1 fw-bold">
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        <span class="fs-2">Initiatives empty</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-5 mt-4">
                                    @if ($act->initiatives->isNotEmpty() && $act->initiatives->last() &&
                                    $act->initiatives->last()->reports->isEmpty())
                                    <div>
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        <span class="fs-2">Not yet started</span>
                                    </div>
                                    @elseif ($act->initiatives->isNotEmpty() && $act->initiatives->last())
                                    <h6 class="pt-1">Presentase <span
                                            class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                                            style="background-color: #e6e3e3">Plan</span> vs
                                        <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder">Actual</span>
                                    </h6>
                                    <div class="mt-1">
                                        <div id="chartActivityWIG_{{ $loop->index }}"></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach ($actIG as $act)
                    <div class="card border-grey shadow mb-3">
                        <div class="card-body py-3 px-4">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <div class="mb-2">
                                                <p class="text-warning fw-bolder mb-1" style="font-size: 11px">
                                                    {{ $act->status }}
                                                </p>
                                                <p class="fw-bolder" style="font-size: 18px">
                                                    {{ $act->objective }}</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 text-end">
                                            <div class="mb-2">
                                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Weight
                                                </p>
                                                <p class="fw-bold">{{ $act->weight }} %</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 text-end">
                                            <div class="mb-2">
                                                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target
                                                </p>
                                                @if ($act->target_type == 'Precentage')
                                                <p class="fw-bold">{{ $act->target }} %</p>
                                                @elseif ($act->target_type == 'Rupiah')
                                                <p class="fw-bold rupiah">Rp.
                                                    {{ number_format($act->target, 0, ',', '.') }}
                                                </p>
                                                @else
                                                <p class="fw-bold">{{ $act->target }} %</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-2 text-end" style="width:25%">
                                            <div class="mb-2">
                                                <a href="{{ route('dashboard.detail', $act->id) }}"
                                                    class="btn btn-sm btn-primary">Scoreboard Detail</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($progresActIG[$act->id] != 0)
                                    <div class="progress" role="progressbar" aria-label="Success example"
                                        aria-valuenow="{{ $progresActIG[$act->id] }}" aria-valuemin="0"
                                        aria-valuemax="100" style="height: 16px">
                                        <div class="progress-bar bg-primary"
                                            style="width: {{ $progresActIG[$act->id] }}%;">
                                            {{ $progresActIG[$act->id] }}%
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-7">
                                    @if ($act->initiatives->isNotEmpty())
                                    <table class="table table-sm table-bordered table-hover mt-4">
                                        <thead>
                                            <tr>
                                                <th scope="col" width="20">No</th>
                                                <th scope="col">Initiatives</th>
                                                <th scope="col" class="text-end">Target</th>
                                                <th scope="col" class="text-end">Actual</th>
                                                <th scope="col" class="text-end">Progres</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-group-divider">
                                            @foreach ($act->initiatives as $init)
                                            <tr>
                                                <td class="text-center">{{ $loop->index+1 }}</td>
                                                <td>{{ $init->initiative }}</td>
                                                @if ($init->target_type == 'Precentage')
                                                <td class="text-end">{{ $init->target }} %</td>
                                                @elseif ($init->target_type == 'Rupiah')
                                                <td class="text-end formattedValue">{{ $init->target }}</td>
                                                @else
                                                <td class="text-end">{{ $init->target }}</td>
                                                @endif
                                                @if ($init->reports && $lastReport = $init->reports->last())
                                                @if ($init->target_type == 'Precentage')
                                                <td class="text-end">{{ $lastReport->actual }} %</td>
                                                @elseif ($init->target_type == 'Rupiah')
                                                <td class="text-end formattedValue">{{ $lastReport->actual }}</td>
                                                @else
                                                <td class="text-end">{{ $lastReport->actual }}</td>
                                                @endif
                                                <td class="text-end">{{ $lastReport->actual/$init->target * 100}} %</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    <div class="mx-1 fw-bold">
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        <span class="fs-2">Initiatives empty</span>
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-5 mt-4">
                                    @if ($act->initiatives->isNotEmpty() && $act->initiatives->last() &&
                                    $act->initiatives->last()->reports->isEmpty())
                                    <div>
                                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                                        <span class="fs-2">Not yet started</span>
                                    </div>
                                    @elseif ($act->initiatives->isNotEmpty() && $act->initiatives->last())
                                    <h6 class="pt-1">Presentase <span
                                            class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                                            style="background-color: #e6e3e3">Plan</span> vs
                                        <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder">Actual</span>
                                    </h6>
                                    <div class="mt-1">
                                        <div id="chartActivityIG_{{ $loop->index }}"></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="card">
                <div class="card-body p-4 shadow-sm">
                    <h5 class="card-title fw-bold">Current Activity Progress : <span
                            class="ps-1 fw-bolder">{{ number_format($grandTotalProgres, 2) }} %</span></h5>
                    <div class="progress" role="progressbar" aria-label="Animated striped example"
                        aria-valuenow="{{ $grandTotalProgres }}" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            style="width: {{ $grandTotalProgres }}%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <!-- Yearly Breakup -->
                    <div class="card">
                        <div class="card-body p-4 shadow-sm">
                            <h5 class="card-title fw-semibold text-center">My Task</h5>
                            <p class="card-text text-center">
                                <span>{{ $tasks['complete'] }}</span>/<span>{{ $tasks['total'] }}</span> Complete!
                            </p>
                            <div class="row align-items-center">
                                <div class="d-flex flex-column align-items-center">
                                    <div class="d-flex justify-content-center">
                                        <div id="myTask"></div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="me-4">
                                            <span class="round-8 rounded-circle me-2 d-inline-block"
                                                style="background-color: #5D87FF"></span>
                                            <span class="fs-2">Complete</span>
                                        </div>
                                        <div>
                                            <span class="round-8 rounded-circle me-2 d-inline-block"
                                                style="background-color: #81b5fc"></span>
                                            <span class="fs-2">Progres</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="round-8 rounded-circle me-2 d-inline-block"
                                            style="background-color: #d2e3fa"></span>
                                        <span class="fs-2">Not yet started</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <!-- Yearly Breakup -->
                    <div class="card">
                        <div class="card-body p-4 shadow-sm">
                            <h5 class="card-title fw-semibold">Complete Your Task Now!</h5>
                            @foreach ($notYetTask as $init)
                            <div class="mb-2">
                                <p class="mb-1">Initiative: {{ $init->initiative }}</p>
                                <p class="mb-1">Bobot: {{ $init->weight }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection