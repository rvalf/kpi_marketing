@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Add New Staff</h5>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('staff.store') }}" method="post">
                @csrf
                <div class="text-center">
                    <h6>Login Information</h6>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username"
                        aria-describedby="inputUsername">
                    <div id="inputUsername" class="form-text">example: staff335</div>
                </div>
                <div class="mb-5">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        aria-describedby="inputPassword">
                    <div id="inputPassword" class="form-text">password must contain min 8 characters</div>
                </div>
                <div class="text-center">
                    <h6>Staff Profile</h6>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="inputEmail">
                    <div id="inputEmail" class="form-text">example: staff335@gmail.com</div>
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname</label>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                        aria-describedby="inputFullname">
                </div>
                <div class="mb-3">
                    <label for="divisi" class="form-label">Divisi</label>
                    <select id="divisi" class="form-select" name="divisi_id">
                        <option value="">Select Divisi</option>
                        @foreach ($divisis as $divID => $name)
                        <option value="{{ $divID }}" @selected(old('divisi_id') == $divID)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>
</div>
@endsection