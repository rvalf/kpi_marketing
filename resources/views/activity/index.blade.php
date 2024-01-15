@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('act.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Activity Plan</h5>
            <table class="table table-bordered border-1">
                <thead>
                    <tr>
                        <th scope="col" width="30">No</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Objective</th>
                        <th scope="col" class="text-center">Weight</th>
                        <th scope="col" class="text-center">Target</th>
                        <th scope="col" class="text-center">Type</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @if($acts->isEmpty())
                    <tr>
                        <td colspan="4">Data is empty! Click Add New to fill this section.</td>
                    </tr>
                    @endif
                    @foreach ($acts as $act)
                    <tr>
                        <th scope="row">{{ $loop->index+1 }}</th>
                        <td>{{ $act->status }}</td>
                        <td>{{ $act->objective }}</td>
                        <td>{{ $act->weight }}</td>
                        <td>{{ $act->target }}</td>
                        <td>{{ $act->type }}</td>
                        <td class="text-center">
                            <button data-bs-toggle="modal" data-bs-target="#showModal_{{ $act->id }}"
                                class="btn btn-secondary"><i class="ti ti-eye"></i> Show</button>
                        </td>
                        <td class="text-center">
                            <a href="" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal_{{ $act->id }}"><i class="ti ti-trash-x"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection