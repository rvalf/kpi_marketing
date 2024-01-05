@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Edit Divisi</h5>
            <form action="{{ route('div.update', $divisi->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Divisi Name</label>
                    <input type="text" class="form-control" id="name" name="namei" aria-describedby="inputExplain" value="{{ old('divisi', $divisi->name) }}">
                    <div id="inputExplain" class="form-text">example: Marketing, Sales, Admin, etc.</div>
                </div>
                <input type="submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>
</div>
@endsection