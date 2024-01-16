@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('div.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Divisi List</h5>
            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th scope="col" width="30">No</th>
                        <th scope="col">Divisi Name</th>
                        <th scope="col" class="text-center">Edit</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @if($divisis->isEmpty())
                    <tr>
                        <td colspan="4">Data is empty! Click Add New to fill this section.</td>
                    </tr>
                    @endif
                    @foreach ($divisis as $div)
                    <tr>
                        <th scope="row">{{ $loop->index+1 }}</th>
                        <td>{{ $div->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('div.edit', ['id' => $div->id ]) }}"
                                class="btn btn-sm btn-outline-primary"><i class="ti ti-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('div.delete', ['id' => $div->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure want to delete this?');">
                                    <i class="ti ti-trash-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection