@extends($layout)

@section('content')
<div class="container-fluid">
    <div class="card border">
        <div class="card-body">
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
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 50%">50%
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1 d-flex justify-content-center align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-primary p-0 px-2 dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-caret-down"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item show-detail" href="#"><i class="ti ti-eye"></i> Initiative</a></li>
                                    @if (Auth::user()->divisi_id === 1)
                                    <li><a class="dropdown-item text-primary"
                                            href="{{ route('act.edit', ['id' => $act->id]) }}"><i
                                                class="ti ti-edit"></i>
                                            Edit</a></li>
                                    <li>
                                        <form action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Are you sure want to delete this?');">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        <td>{{ $init->target }} %</td>
                                        <td>{{ $init->user->fullname }}</td>
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
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 50%">50%
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
                                        <form action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Are you sure want to delete this?');">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($act->initiatives as $init)
                                    <tr>
                                        <td scope="row" class="text-end">{{ $loop->iteration }} .</td>
                                        <td>{{ $init->initiative }}</td>
                                        <td>{{ $init->weight }} %</td>
                                        <td>{{ $init->target }} %</td>
                                        <td>{{ $init->user->fullname }}</td>
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

<!-- <table class="table table-bordered table-sm" id="table-body">
                <thead>
                    <tr>
                        <th scope="col" width="30">No</th>
                        <th scope="col" class="text-center">Objective</th>
                        <th scope="col" class="text-center">Weight</th>
                        <th scope="col" class="text-center">Target</th>
                        <th scope="col" class="text-center">Progres</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @if($acts->isEmpty())
                    <tr>
                        <td colspan="4">Data is empty! Click Add New to fill this section.</td>
                    </tr>
                    @else
                    <tr>
                        <th colspan="3" class="pt-2 m-0">
                            <span class="bg-primary p-1 px-2 text-white rounded-2 m-0" style="width: fit-content">Wildly
                                Important Goal (WIG)</span><span class="fw-bold ps-2">{{ $WIGWeight }} %</span>
                        </th>
                    </tr>
                    @foreach ($acts as $act)
                    @if ($act->status == 'Wildly Important Goal (WIG)')
                    <tr>
                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                        <td>{{ $act->objective }}</td>
                        <td class="text-end">{{ $act->weight }} %</td>
                        @if ($act->target_type === 'Precentage')
                        <td class="text-end">{{ $act->target }}%</td>
                        @elseif ($act->target_type === 'Rupiah')
                        <td class="text-end">Rp. {{ $act->target }}</td>
                        @else
                        <td class="text-end">{{ $act->target }}</td>
                        @endif
                        <td>
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 50%">50%
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn p-0 px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item show-initiative" href="#"><i class="ti ti-eye"></i> Show
                                            Initiative</a></li>
                                    <li><a class="dropdown-item text-primary"
                                            href="{{ route('act.edit', ['id' => $act->id]) }}"><i
                                                class="ti ti-edit"></i>
                                            Edit</a></li>
                                    <li>
                                        <form action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Are you sure want to delete this?');">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="6">This is Initiative</td>
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <th colspan="3" class="pt-2 m-0">
                            <span class="bg-secondary p-1 px-2 text-white rounded-2 m-0" style="width: fit-content">
                                Important Goal (IG)</span><span class="fw-bold ps-2">{{ $IGWeight }} %</span>
                        </th>
                    </tr>
                    @foreach ($acts as $act)
                    @if ($act->status == 'Important Goal (IG)')
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $act->objective }}</td>
                        <td class="text-end">{{ $act->weight }} %</td>
                        @if ($act->target_type === 'Precentage')
                        <td class="text-end">{{ $act->target }}%</td>
                        @elseif ($act->target_type === 'Rupiah')
                        <td class="text-end">Rp. {{ $act->target }}</td>
                        @else
                        <td class="text-end">{{ $act->target }}</td>
                        @endif
                        <td>
                            <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar bg-success" style="width: 50%">50%
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn p-0 px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item show-initiative" href="#"><i class="ti ti-eye"></i> Show
                                            Initiative</a></li>
                                    <li><a class="dropdown-item text-primary"
                                            href="{{ route('act.edit', ['id' => $act->id]) }}"><i
                                                class="ti ti-edit"></i> Edit</a></li>
                                    <li>
                                        <form action="{{ route('act.delete', ['id' => $act->id]) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Are you sure want to delete this?');">
                                                <i class="ti ti-trash-x"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="6">This is Initiative</td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table> -->