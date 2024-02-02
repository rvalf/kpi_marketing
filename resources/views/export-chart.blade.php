<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Marketing</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Internal Styles -->
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;700&display=swap');

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .text-primary {
        color: #007bff !important;
    }

    .fw-bolder {
        font-weight: bolder !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }
    </style>
</head>

<body>
    <h3 class="fw-bolder">Score Board</h3>
    @foreach ($actWIG as $act)
    <div class="card border-grey shadow mb-3">
        <div class="card-body py-3 px-4">
            <div>
                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                    {{ $act->status }}
                </p>
                <p class="fw-bolder" style="font-size: 18px">
                    {{ $act->objective }}</p>
            </div>
            <table>
                <tr>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Weight</td>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Target</td>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Progres</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ $act->weight }} %</td>
                    @if ($act->target_type == 'Precentage')
                    <td class="fw-bold">{{ $act->target }} %</td>
                    @elseif ($act->target_type == 'Rupiah')
                    <td class="fw-bold">Rp. {{ number_format($act->target, 0, ',', '.') }}</td>
                    @else
                    <td class="fw-bold">{{ $act->target }} %</td>
                    @endif
                    @if ($progresActWIG[$act->id] != 0)
                    <td class="fw-bold">{{ $progresActWIG[$act->id] }} %</td>
                    @endif
                </tr>
            </table>
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
                        <td class="text-end">{{ number_format($init->target, 0, ',', '.') }}</td>
                        @else
                        <td class="text-end">{{ $init->target }}</td>
                        @endif
                        @if ($init->reports && $lastReport = $init->reports->last())
                        @if ($init->target_type == 'Precentage')
                        <td class="text-end">{{ $lastReport->actual }} %</td>
                        @elseif ($init->target_type == 'Rupiah')
                        <td class="text-end">{{ number_format($lastReport->actual, 0, ',', '.') }}</td>
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
                <p class="fs-2 mt-3 text-danger"><i>Initiatives empty</i></p>
            </div>
            @endif
            <!-- <div class="col-sm-6 mt-4">
                    @if ($act->initiatives->isNotEmpty() && $act->initiatives->last() &&
                    $act->initiatives->last()->reports->isEmpty())
                    <div>
                        <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                        <span class="fs-2">Not yet started</span>
                    </div>
                    @elseif ($act->initiatives->isNotEmpty() && $act->initiatives->last())
                    <h6 class="pt-1">Presentase <span class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                            style="background-color: #e6e3e3">Plan</span> vs
                        <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder" style="color:white">Actual</span>
                    </h6>
                    <div class="mt-1">
                        <div id="chartActivityWIG_{{ $loop->index }}"></div>
                    </div>
                    @endif
                </div> -->
        </div>
    </div>
    @endforeach
    @foreach ($actIG as $act)
    <div class="card border-grey shadow mb-3">
        <div class="card-body py-3 px-4">
            <div>
                <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                    {{ $act->status }}
                </p>
                <p class="fw-bolder" style="font-size: 18px">
                    {{ $act->objective }}</p>
            </div>
            <table>
                <tr>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Weight</td>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Target</td>
                    <td class="text-primary fw-bolder mb-1" style="font-size:11px; width:70px">Progres</td>
                </tr>
                <tr>
                    <td class="fw-bold">{{ $act->weight }} %</td>
                    @if ($act->target_type == 'Precentage')
                    <td class="fw-bold">{{ $act->target }} %</td>
                    @elseif ($act->target_type == 'Rupiah')
                    <td class="fw-bold">Rp. {{ number_format($act->target, 0, ',', '.') }}</td>
                    @else
                    <td class="fw-bold">{{ $act->target }} %</td>
                    @endif
                    @if ($progresActIG[$act->id] != 0)
                    <td class="fw-bold">{{ $progresActIG[$act->id] }} %</td>
                    @endif
                </tr>
            </table>
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
                        <td class="text-end">{{ number_format($init->target, 0, ',', '.') }}</td>
                        @else
                        <td class="text-end">{{ $init->target }}</td>
                        @endif
                        @if ($init->reports && $lastReport = $init->reports->last())
                        @if ($init->target_type == 'Precentage')
                        <td class="text-end">{{ $lastReport->actual }} %</td>
                        @elseif ($init->target_type == 'Rupiah')
                        <td class="text-end">{{ number_format($lastReport->actual, 0, ',', '.') }}</td>
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
                <p class="fs-2 mt-3 text-danger"><i>Initiatives empty</i></p>
            </div>
            @endif
        </div>
        <!-- <div class="col-sm-6 mt-4">
                @if ($act->initiatives->isNotEmpty() && $act->initiatives->last() &&
                $act->initiatives->last()->reports->isEmpty())
                <div>
                    <span class="round-8 bg-danger rounded-circle me-1 d-inline-block"></span>
                    <span class="fs-2">Not yet started</span>
                </div>
                @elseif ($act->initiatives->isNotEmpty() && $act->initiatives->last())
                <h6 class="pt-1">Presentase <span class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                        style="background-color: #e6e3e3">Plan</span> vs
                    <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder">Actual</span>
                </h6>
                <div class="mt-1">
                    <div id="chartActivityIG_{{ $loop->index }}"></div>
                </div>
                @endif
            </div> -->
    </div>
    </div>
    @endforeach
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>

</html>