@extends($layout)

@section('content')
<div class="container-fluid">
    <div class="card border">
        <div class="card-body">
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
            @if (Auth::user()->divisi_id === 1)
            <p class="badge bg-primary mb-2 rounded-3 mb-3" style="font-size: 12px">Wildly Important Goal - Max Weight:
                60%<span class="badge bg-light text-dark p-1 ms-2 rounded-3" style="font-size: 11px">Current:
                    {{ $WIGWeight }}%</span></p>
            @foreach ($actWIG as $act)
            <div class="card border-grey shadow mb-3">
                <div class="card-body py-3 px-4">
                    <div class="row">
                        <div class="col-sm-7">
                            <p class="sub-title">Objective</p>
                            <p class="m-0 fw-bolder">{{ $act->objective }}</p>
                        </div>
                        <div class="col-sm-1">
                            <p class="sub-title">Weight</p>
                            <p class="m-0">{{ $act->weight }} %</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="sub-title text-center">Progress</p>
                            <div class="progress" role="progressbar" aria-label="Success example"
                                aria-valuenow="{{ $progresActWIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: {{ $progresActWIG[$act->id] }}%">
                                    {{ $progresActWIG[$act->id] }}%
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <a href="{{ route('init.create', ['act_id' => $act->id]) }}"
                                class="btn btn-outline-secondary my-1"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                    <div class="target mt-2">
                        @if ($act->target_type == 'Rupiah')
                        <p class="m-0" style="font-size: 11px;">Target : Rp.
                            {{ number_format($act->target, 0, ',', '.') }}</p>
                        @elseif ($act->target_type == 'Precentage')
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }} %</p>
                        @else
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }}</p>
                        @endif
                    </div>
                    <div class="details mt-3" style="display: block;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col">Progres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        @if ($init->target_type == 'Precentage')
                                        <td>{{ $init->target }} %</td>
                                        @elseif ($init->target_type == 'Rupiah')
                                        <td class="formattedValue">{{ $init->target }}</td>
                                        @else
                                        <td>{{ $init->target }}</td>
                                        @endif
                                        <td>{{ $init->user->fullname }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary"
                                                href="{{ route('init.edit', ['id' => $init->id]) }}"><i
                                                    class="ti ti-edit"></i></a>
                                        </td>
                                        <td>
                                            <form id="deleteForm_{{ $init->id }}"
                                                action="{{ route('init.delete', ['id' => $init->id]) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete('{{ $init->id }}')">
                                                    <i class="ti ti-trash-x"></i>
                                                </button>
                                            </form>
                                        </td>

                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                        <script>
                                        function confirmDelete(initId) {
                                            Swal.fire({
                                                title: 'Delete Initiative',
                                                text: 'Are you sure you want to delete this? If the initiative already has reports, the data cannot be deleted.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#d33',
                                                cancelButtonColor: '#3085d6',
                                                confirmButtonText: 'Delete',
                                                customClass: {
                                                    popup: 'swal2-sm'
                                                }
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('deleteForm_' + initId).submit();
                                                }
                                            });
                                        }
                                        </script>
                                        <td>
                                            @if ($init->reports && $lastReport = $init->reports->last())
                                            @if ($init->target_type != 'Precentage')
                                            @php
                                            $lastReportActual = $init->reports->last()->actual;
                                            $currentProgres = ($lastReportActual/$init->target) * 100;
                                            @endphp
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="{{ $currentProgres }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $currentProgres }}%">
                                                    {{ $currentProgres }}%
                                                </div>
                                            </div>
                                            @else
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $init->reports->last()->actual }}%">
                                                    {{ $init->reports->last()->actual }}%
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <p class="badge bg-warning mb-2 rounded-3 mb-3" style="font-size: 12px">Important Goal - Max Weight:
                40%<span class="badge bg-light text-dark p-1 ms-2 rounded-3" style="font-size: 11px">
                    Current: {{ $IGWeight }}%</span>
            </p>
            @foreach ($actIG as $act)
            <div class="card border-grey shadow mb-3">
                <div class="card-body py-3 px-4">
                    <div class="row">
                        <div class="col-sm-7">
                            <p class="sub-title">Objective</p>
                            <p class="m-0 fw-bolder">{{ $act->objective }}</p>
                        </div>
                        <div class="col-sm-1">
                            <p class="sub-title">Weight</p>
                            <p class="m-0">{{ $act->weight }} %</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="sub-title text-center">Progress</p>
                            <div class="progress" role="progressbar" aria-label="Success example"
                                aria-valuenow="{{ $progresActIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: {{ $progresActIG[$act->id] }}%">
                                    {{ $progresActIG[$act->id] }}%
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <a href="{{ route('init.create', ['act_id' => $act->id]) }}"
                                class="btn btn-outline-secondary my-1"><i class="ti ti-plus"></i></a>
                        </div>
                    </div>
                    <div class="target mt-2">
                        @if ($act->target_type == 'Rupiah')
                        <p class="m-0" style="font-size: 11px;">Target : Rp.
                            {{ number_format($act->target, 0, ',', '.') }}</p>
                        @elseif ($act->target_type == 'Precentage')
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }} %</p>
                        @else
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }}</p>
                        @endif
                    </div>
                    <div class="details mt-3" style="display: block;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col">Progres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        @if ($init->target_type == 'Precentage')
                                        <td>{{ $init->target }} %</td>
                                        @elseif ($init->target_type == 'Rupiah')
                                        <td class="formattedValue">{{ $init->target }}</td>
                                        @else
                                        <td>{{ $init->target }}</td>
                                        @endif
                                        <td>{{ $init->user->fullname }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-secondary"
                                                href="{{ route('init.edit', ['id' => $init->id]) }}"><i
                                                    class="ti ti-edit"></i></a>
                                        </td>
                                        <td>
                                            <form action="{{ route('init.delete', ['id' => $init->id]) }}" method="POST"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure want to delete this?');">
                                                    <i class="ti ti-trash-x"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            @if ($init->reports && $lastReport = $init->reports->last())
                                            @if ($init->target_type != 'Precentage')
                                            @php
                                            $lastReportActual = $init->reports->last()->actual;
                                            $currentProgres = ($lastReportActual/$init->target) * 100;
                                            @endphp
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="{{ $currentProgres }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $currentProgres }}%">
                                                    {{ $currentProgres }}%
                                                </div>
                                            </div>
                                            @else
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $init->reports->last()->actual }}%">
                                                    {{ $init->reports->last()->actual }}%
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- ISI HALAMAN STAFF -->
            @else

            @php
            $authenticatedUserId = Auth::user()->id;

            $hasInitiativeActWIG = collect($actWIG)->some(function ($activity) use ($authenticatedUserId) {
            return $activity->initiatives->contains('user_id', $authenticatedUserId);
            });

            $hasInitiativeActIG = collect($actIG)->some(function ($activity) use ($authenticatedUserId) {
            return $activity->initiatives->contains('user_id', $authenticatedUserId);
            });
            @endphp

            @if (!$hasInitiativeActWIG && !$hasInitiativeActIG)
            <div class="alert alert-warning mb-3">
                Sorry, you have no assignments to report. Please contact the Manager to receive the assignment!
            </div>
            @endif


            @foreach ($actWIG as $act)
            @if ($act->initiatives->contains('user_id', Auth::user()->id))
            @if ($loop->index == 0)
            <p class="badge bg-primary mb-2 rounded-3 mb-3" style="font-size: 12px">Wildly Important Goal</p>
            @endif
            <div class="card border-grey shadow mb-3">
                <div class="card-body py-3 px-4">
                    <div class="row">
                        <div class="col-sm-7">
                            <p class="sub-title">Objective</p>
                            <p class="m-0 fw-bolder">{{ $act->objective }}</p>
                        </div>
                        <div class="col-sm-1">
                            <p class="sub-title">Weight</p>
                            <p class="m-0">{{ $act->weight }} %</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="sub-title text-center">Progress</p>
                            <div class="progress" role="progressbar" aria-label="Success example"
                                aria-valuenow="{{ $progresActWIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: {{ $progresActWIG[$act->id] }}%">
                                    {{ $progresActWIG[$act->id] }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="target mt-2">
                        @if ($act->target_type == 'Rupiah')
                        <p class="m-0" style="font-size: 11px;">Target : Rp.
                            {{ number_format($act->target, 0, ',', '.') }}</p>
                        @elseif ($act->target_type == 'Precentage')
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }} %</p>
                        @else
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }}</p>
                        @endif
                    </div>
                    <div class="details mt-3" style="display: block;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Progres</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col" class="text-center">Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    @if ($init->user->id === Auth::user()->id)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        @if ($init->target_type == 'Precentage')
                                        <td>{{ $init->target }} %</td>
                                        @elseif ($init->target_type == 'Rupiah')
                                        <td class="formattedValue">{{ $init->target }}</td>
                                        @else
                                        <td>{{ $init->target }}</td>
                                        @endif
                                        <td>
                                            @if ($init->reports && $lastReport = $init->reports->last())
                                            @if ($init->target_type != 'Precentage')
                                            @php
                                            $lastReportActual = $init->reports->last()->actual;
                                            $currentProgres = ($lastReportActual/$init->target) * 100;
                                            @endphp
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="{{ $currentProgres }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $currentProgres }}%">
                                                    {{ $currentProgres }}%
                                                </div>
                                            </div>
                                            @else
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $init->reports->last()->actual }}%">
                                                    {{ $init->reports->last()->actual }}%
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                        <td>{{ $init->user->fullname }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('report.index') }}" class="btn btn-sm btn-secondary"><i
                                                    class="ti ti-pencil"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

            @foreach ($actIG as $act)
            @if ($act->initiatives->contains('user_id', Auth::user()->id))
            @if ($loop->index == 0)
            <p class="badge bg-warning mb-2 rounded-3 mb-3" style="font-size: 12px">Important Goal</p>
            @endif
            <div class="card border-grey shadow mb-3">
                <div class="card-body py-3 px-4">
                    <div class="row">
                        <div class="col-sm-7">
                            <p class="sub-title">Objective</p>
                            <p class="m-0 fw-bolder">{{ $act->objective }}</p>
                        </div>
                        <div class="col-sm-1">
                            <p class="sub-title">Weight</p>
                            <p class="m-0">{{ $act->weight }} %</p>
                        </div>
                        <div class="col-sm-3">
                            <p class="sub-title text-center">Progress</p>
                            <div class="progress" role="progressbar" aria-label="Success example"
                                aria-valuenow="{{ $progresActIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: {{ $progresActIG[$act->id] }}%">
                                    {{ $progresActIG[$act->id] }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="target mt-2">
                        @if ($act->target_type == 'Rupiah')
                        <p class="m-0" style="font-size: 11px;">Target : Rp.
                            {{ number_format($act->target, 0, ',', '.') }}</p>
                        @elseif ($act->target_type == 'Precentage')
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }} %</p>
                        @else
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }}</p>
                        @endif
                    </div>
                    <div class="details mt-3" style="display: block;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">Progres</th>
                                        <th scope="col">PIC</th>
                                        <th scope="col" class="text-center">Report</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    @if ($init->user->id === Auth::user()->id)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        @if ($init->target_type == 'Precentage')
                                        <td>{{ $init->target }} %</td>
                                        @elseif ($init->target_type == 'Rupiah')
                                        <td class="formattedValue">{{ $init->target }}</td>
                                        @else
                                        <td>{{ $init->target }}</td>
                                        @endif
                                        <td>
                                            @if ($init->reports && $lastReport = $init->reports->last())
                                            @if ($init->target_type != 'Precentage')
                                            @php
                                            $lastReportActual = $init->reports->last()->actual;
                                            $currentProgres = ($lastReportActual/$init->target) * 100;
                                            @endphp
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="{{ $currentProgres }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $currentProgres }}%">
                                                    {{ $currentProgres }}%
                                                </div>
                                            </div>
                                            @else
                                            <div class="progress" role="progressbar" aria-label="Success example"
                                                aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar bg-success"
                                                    style="width: {{ $init->reports->last()->actual }}%">
                                                    {{ $init->reports->last()->actual }}%
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                        </td>
                                        <td>{{ $init->user->fullname }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('report.index') }}" class="btn btn-sm btn-secondary"><i
                                                    class="ti ti-pencil"></i></a>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif
        </div>
    </div>
</div>
@endsection