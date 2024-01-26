@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="card">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

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
        
        <div class="card-body d-flex">
            <div class="pe-5">
                <h5 class="card-title fw-semibold my-4">My Profile</h5>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK (No Induk) :</label>
                    <label for="npk" class="form-label">{{ $user->npk }}</label>
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Name :</label>
                    <label for="name" class="form-label">{{ $user->fullname }}</label>
                </div>
                <div class="mb-3">
                    <label for="divisi" class="form-label">Department :</label>
                    <label for="divisi" class="form-label">{{ $user->divisi->name }}</label>
                </div>
                <div class="mb-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#changePassword">Change Password</button>
                </div>
            </div>
            <div class="ps-5">
                <h5 class="card-title fw-semibold my-4">Login Information</h5>
                <div class="mb-3">
                    <label for="username" class="form-label">Username :</label>
                    <label for="username" class="form-label">{{ $user->divisi->name }}</label>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email :</label>
                    <label for="email" class="form-label">{{ $user->email }}</label>
                </div>
                <div class="mb-3">
                    @if ($user->created_at == $user->updated_at)
                    <label for="email" class="form-label text-danger">Please change your password!</label>
                    @endif
                </div>
            </div>

            <!-- Change Password Modal -->
            <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('staff.update', $user->id) }}" method="post">
                            @method('PUT')
                            @csrf
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="changePasswordModalabel">Change Password
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-2">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        aria-describedby="inputExplain" required>
                                    <div id="inputExplain" class="form-text">Password must be at least 8 characters.
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="confirmPassword" aria-describedby="inputExplain" required>
                                    <div id="inputExplain" class="form-text">Please re-type the password.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection