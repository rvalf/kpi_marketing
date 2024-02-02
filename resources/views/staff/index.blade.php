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
            <a href="{{ route('staff.create') }}" class="btn btn-outline-secondary my-1"><i
                    class="ti ti-plus pe-2"></i>Add New</a>
            <h5 class="card-title fw-semibold my-4">Staff List</h5>
            <table id="tableStaff" class="table table-sm table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col" width="30" class="text-center">No</th>
                        <th scope="col" class="text-center">NPK</th>
                        <th scope="col" class="text-center">Name</th>
                        <th scope="col" class="text-center">Department</th>
                        <th scope="col" class="text-center">Account</th>
                        <th scope="col" class="text-center">Delete</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @if($staffs->isEmpty())
                    <tr>
                        <td colspan="4">Data is empty! Click Add New to fill this section.</td>
                    </tr>
                    @endif
                    @foreach ($staffs as $staff)
                    <tr>
                        <td class="text-center auto-number"></td>
                        <td>{{ $staff->npk }}</td>
                        <td>{{ $staff->fullname }}</td>
                        <td>{{ $staff->divisi->name }}</td>
                        <td class="text-center">
                            <button data-bs-toggle="modal" data-bs-target="#showModal_{{ $staff->id }}"
                                class="btn btn-sm btn-secondary"><i class="ti ti-eye"></i></button>
                        </td>
                        <div class="modal fade" id="showModal_{{ $staff->id }}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Staff Profile</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row ps-3">
                                                <div class="col-sm-3">
                                                    <p>Username </p>
                                                    <p>Name </p>
                                                    <p>Email </p>
                                                    <p>Divisi </p>
                                                </div>
                                                <div class="col-sm-9">
                                                    <p class="fw-semi-bold">: {{ $staff->username }}</p>
                                                    <p class="fw-semi-bold">: {{ $staff->fullname }}</p>
                                                    <p class="fw-semi-bold">: {{ $staff->email }}</p>
                                                    <p class="fw-semi-bold">: {{ $staff->divisi->name }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td class="text-center">
                            <form id="deleteForm_{{ $staff->id }}"
                                action="{{ route('staff.delete', ['id' => $staff->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                    onclick="confirmDelete('{{ $staff->id }}')">
                                    <i class="ti ti-trash-x"></i>
                                </button>
                            </form>
                        </td>

                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                        function confirmDelete(staffId) {
                            Swal.fire({
                                title: 'Delete Staff',
                                text: 'Staff will be disabled. Are you sure you want to delete this?',
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
                                    document.getElementById('deleteForm_' + staffId).submit();
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