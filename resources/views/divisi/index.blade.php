@extends('layouts.manager')

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
            <a href="{{ route('div.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Department List</h5>
            <table id="tableDivisi" class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="30" class="text-center">No</th>
                        <th scope="col" class="text-center">Department Name</th>
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
                        <td class="text-center auto-number"></td>
                        <td>{{ $div->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('div.edit', ['id' => $div->id ]) }}"
                                class="btn btn-sm btn-outline-primary"><i class="ti ti-edit"></i></a>
                        </td>
                        <td class="text-center">
                            <form id="deleteForm_{{ $div->id }}" action="{{ route('div.delete', ['id' => $div->id]) }}"
                                method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDelete('{{ $div->id }}')">
                                    <i class="ti ti-trash-x"></i>
                                </button>
                            </form>
                        </td>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        function confirmDelete(divId) {
                            Swal.fire({
                                title: 'Delete Department',
                                text: 'Are you sure you want to delete this?',
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
                                    document.getElementById('deleteForm_' + divId).submit();
                                }
                            });
                        }
                        </script>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection