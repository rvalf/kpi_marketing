@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <!-- <a href="{{ route('init.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a> -->
            <h5 class="card-title fw-semibold my-4">Initiative</h5>
            <table class="table table-striped table-group-divider" id="table-body">
                <thead>
                    <tr>
                        <!-- <th scope="col" width="30">NO</th> -->
                        <th scope="col" class="text-center">OBJECTIVE</th>
                        <th scope="col" class="text-center">WEIGHT</th>
                        <th scope="col" class="text-center">TARGET</th>
                        <th scope="col" class="text-center">DETAIL</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($acts as $act)
                    <tr>
                        <td>{{ $act->objective }}</td>
                        <td>{{ $act->weight }} %</td>
                        @if ($act->target_type === 'Precentage')
                        <td class="text-end">{{ $act->target }}%</td>
                        @elseif ($act->target_type === 'Rupiah')
                        <td class="text-end">Rp. {{ $act->target }}</td>
                        @else
                        <td class="text-end">{{ $act->target }}</td>
                        @endif
                        <td>
                            <a class="btn btn-sm btn-primary show-initiative" href="#"><i class="ti ti-eye"></i> Initiative</a>
                        </td>
                    </tr>
                    <tr style="display: none;">
                        <td colspan="4">
                        <table class="table table-bordered border-dark table-sm">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">INITIATIVE</th>
                                    <th scope="col" class="text-center">WEIGHT</th>
                                    <th scope="col" class="text-center">TARGET</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Proposal</td>
                                    <td>20 %</td>
                                    <td>100 %</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
<!-- 
@if($inits->isEmpty())
<tr>
    <td colspan="4">Data is empty! Click Add New to fill this section.</td>
</tr>
@else
@foreach ($inits as $init)
<tr>
    <th scope="row">{{ $loop->iteration }}</th>
    <td>{{ $init->initiative }}</td>
    <td class="text-end">{{ $init->weight }} %</td>
    @if ($init->target_type === 'Precentage')
    <td class="text-end">{{ $init->target }}%</td>
    @elseif ($init->target_type === 'Rupiah')
    <td class="text-end">Rp. {{ $init->target }}</td>
    @else
    <td class="text-end">{{ $init->target }}</td>
    @endif
    <td>
        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0"
            aria-valuemax="100">
            <div class="progress-bar bg-success" style="width: 50%">50%
            </div>
        </div>
    </td>
    <td class="text-center">
        <div class="dropdown">
            <button class="btn p-0 px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item text-primary" href="{{ route('init.edit', ['id' => $init->id]) }}"><i
                            class="ti ti-edit"></i>
                        Edit</a></li>
                <li>
                    <form action="{{ route('init.delete', ['id' => $init->id]) }}" method="POST"
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
@endforeach
@endif -->