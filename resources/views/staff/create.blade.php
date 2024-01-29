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
                    <label for="username" class="form-label">Username <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="username" name="username"
                        aria-describedby="inputUsername" value="{{ old('username') }}">
                    <div id="inputUsername" class="form-text">example: staff335</div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="inputEmail" value="{{ old('email') }}">
                    <div id="inputEmail" class="form-text">example: staff335@gmail.com</div>
                </div>
                <div class="text-center">
                    <h6>Staff Profile</h6>
                </div>
                <div class="mb-3">
                    <label for="npk" class="form-label">NPK (No Induk) <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="npk" name="npk"
                        aria-describedby="inputnpk" value="{{ old('npk') }}">
                </div>
                <div class="mb-3">
                    <label for="fullname" class="form-label">Fullname <span style="color: red;">*</span></label>
                    <input type="text" class="form-control" id="fullname" name="fullname"
                        aria-describedby="inputFullname" value="{{ old('fullname') }}">
                </div>
                <div class="mb-3">
                    <label for="divisi" class="form-label">Department <span style="color: red;">*</span></label>
                    <select id="divisi" class="form-select" name="divisi_id">
                        <option value="">Select Department</option>
                        @foreach ($divisis as $divID => $name)
                        <option value="{{ $divID }}" @selected(old('divisi_id') == $divID)>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('staff.index') }}" class="btn btn-danger">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection