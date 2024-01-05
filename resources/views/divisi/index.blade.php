@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('div.create') }}" class="btn btn-outline-secondary my-1"><i class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">List Divisi</h5>
            <table class="table table-bordered border-1">
                <thead>
                    <tr>
                        <th scope="col" width="30"></th>
                        <th scope="col" class="text-center">Divisi Name</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($divisis as $div)
                    <tr>
                        <th scope="row">{{ $loop->index+1 }}</th>
                        <td>{{ $div->name }}</td>
                        <td class="text-center">
                            <a href="" class="btn btn-primary"><i class="ti ti-edit"></i> Edit</a>
                        </td>
                        <td class="text-center">
                            <a href="" class="btn btn-danger"><i class="ti ti-trash-x"></i> Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection