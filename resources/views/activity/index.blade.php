@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('act.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Activity Plan</h5>
            <table class="table table-bordered border-1 table-group-divider" id="table-body">
                <thead>
                    <tr>
                        <th scope="col" width="30">NO</th>
                        <th scope="col" class="text-center">OBJECTIVE</th>
                        <th scope="col" class="text-center">WEIGHT</th>
                        <th scope="col" class="text-center">TARGET</th>
                        <th scope="col" class="text-center">PROGRES</th>
                        <th scope="col" class="text-center">ACTION</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @if($acts->isEmpty())
                    <tr>
                        <td colspan="4">Data is empty! Click Add New to fill this section.</td>
                    </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="ps-2 pt-3 m-0">
                            <span class="bg-primary p-1 px-2 text-white rounded-2 m-0" style="width: fit-content">Wildly
                                Important Goal (WIG)</span><span class="fw-bold ps-2">{{ $WIGWeight }} %</span>
                        </th>
                    </tr>
                    @foreach ($acts as $act)
                    @if ($act->status == 'Wildly Important Goal (WIG)')
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
                                <div class="progress-bar bg-success" style="width: 50%">
                                    <p style="font-size: 10px; padding-top: 50%;">50%</p>
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
                        <th colspan="3" class="ps-2 pt-3 m-0">
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
                                <div class="progress-bar bg-success" style="width: 50%">
                                    <p style="font-size: 10px; padding-top: 50%;">50%</p>
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
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection