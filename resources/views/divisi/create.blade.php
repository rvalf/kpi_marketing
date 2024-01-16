@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Add New Divisi</h5>
            <form action="{{ route('div.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Divisi Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="inputExplain">
                    <div id="inputExplain" class="form-text">example: Marketing, Sales, Admin, etc.</div>
                </div>
                <input type="submit" value="Submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>
</div>
@endsection