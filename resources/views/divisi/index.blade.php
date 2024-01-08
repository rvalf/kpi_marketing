@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="{{ route('div.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Divisi Listi</h5>
            <table class="table table-bordered border-1">
                <thead>
                    <tr>
                        <th scope="col" width="30">No</th>
                        <th scope="col" class="text-center">Divisi Name</th>
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
                            <a href="{{ route('div.edit', ['id' => $div->id ]) }}" class="btn btn-outline-primary"><i
                                    class="ti ti-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <a href="" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal_{{ $div->id }}"><i class="ti ti-trash-x"></i></a>
                        </td>
                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal_{{ $div->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="text-center m-0">Are you sure want to delete this?</p>
                                        <P class="text-center m-0">The data will be removed from the database.</P>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <form id="deleteForm_{{ $div->id }}"
                                            action="{{ route('div.delete', ['id' => $div->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection