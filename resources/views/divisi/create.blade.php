@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Add New Department</h5>
            <form action="{{ route('div.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="inputExplain"
                        required value="{{ old('name') }}">
                    <div id="inputExplain" class="form-text">example: Marketing, Sales, Admin, etc.</div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('div.index') }}" class="btn btn-danger">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection