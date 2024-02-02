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
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-semibold">Activity Plan</h5>
                @if (Auth::user()->divisi_id === 1)
                <a href="{{ route('act.create') }}" class="btn btn-outline-secondary my-1"><i
                        class="ti ti-plus pe-2"></i>Add New</a>
                @endif
            </div>
            <p class="badge bg-primary mb-2 rounded-3 mb-3" style="font-size: 12px">Wildly Important Goal <span
                    class="badge bg-light text-dark p-1 ms-2 rounded-3" style="font-size: 11px">
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
                        <div class="col-sm-1 d-flex justify-content-center align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-primary p-0 px-2 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item show-detail" href="#"><i class="ti ti-eye"></i>
                                            Initiative</a></li>
                                    @if (Auth::user()->divisi_id === 1)
                                    <li><a class="dropdown-item text-primary"
                                            href="{{ route('act.edit', ['id' => $act->id]) }}"><i
                                                class="ti ti-edit"></i>
                                            Edit</a></li>
                                    <li>
                                        <form id="deleteForm_{{ $act->id }}"
                                            action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger"
                                                onclick="confirmDelete('{{ $act->id }}')">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>

                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                    function confirmDelete(actId) {
                                        Swal.fire({
                                            title: 'Delete Activity',
                                            text: 'Are you sure you want to delete this? If the activity already has initiatives, the data cannot be deleted.',
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
                                                document.getElementById('deleteForm_' + actId).submit();
                                            }
                                        });
                                    }
                                    </script>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="target mt-2">
                        @if ($act->target_type == 'Rupiah')
                        <p class="m-0" style="font-size: 11px;">Target : Rp. <span
                                class="formattedValue">{{ $act->target }}</span></p>
                        @elseif ($act->target_type == 'Precentage')
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }} %</p>
                        @else
                        <p class="m-0" style="font-size: 11px;">Target : {{ $act->target }}</p>
                        @endif
                    </div>
                    <div class="details mt-3" style="display: none;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">PIC</th>
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

            <p class="badge bg-warning mb-2 rounded-3 mb-3" style="font-size: 12px">Important Goal <span
                    class="badge bg-light text-dark p-1 ms-2 rounded-3" style="font-size: 11px"> {{ $IGWeight }}%</span>
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
                        <div class="col-sm-1 d-flex justify-content-center align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-primary p-0 px-2 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item show-detail" href="#"><i class="ti ti-eye"></i>
                                            Initiative</a></li>
                                    @if (Auth::user()->divisi_id === 1)
                                    <li><a class="dropdown-item text-primary"
                                            href="{{ route('act.edit', ['id' => $act->id]) }}"><i
                                                class="ti ti-edit"></i>
                                            Edit</a></li>
                                    <li>
                                        <form id="deleteForm_{{ $act->id }}"
                                            action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger"
                                                onclick="confirmDelete('{{ $act->id }}')">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>

                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                    function confirmDelete(actId) {
                                        Swal.fire({
                                            title: 'Delete Activity',
                                            text: 'Are you sure you want to delete this? If the activity already has initiatives, the data cannot be deleted.',
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
                                                document.getElementById('deleteForm_' + actId).submit();
                                            }
                                        });
                                    }
                                    </script>
                                    @endif
                                </ul>
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
                    <div class="details mt-3" style="display: none;">
                        <div class="initiative ps-4">
                            <table class="table table-sm table-detail">
                                <thead>
                                    <tr>
                                        <th scope="col" style="width: 25px;"></th>
                                        <th scope="col">Initiative</th>
                                        <th scope="col">Weight</th>
                                        <th scope="col">Target</th>
                                        <th scope="col">PIC</th>
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
        </div>
    </div>
</div>
@endsection