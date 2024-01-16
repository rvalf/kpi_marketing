@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-sm-7 pe-4">
                    @if($errors->any())
                    <div class="alert alert-danger m-0">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <h5 class="card-title fw-semibold my-2">Add New Initiative</h5>
                    <form action="{{ route('init.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="activity" class="form-label">Activity</label>
                            <select id="activity" class="form-select" name="activity_id" required>
                                <option value="">Select Activity</option>
                                @foreach ($acts as $actId => $act)
                                <option value="{{ $actId }}">{{ $act }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="initiative" class="form-label">Initiative</label>
                            <textarea class="form-control" id="initiative" name="initiative"
                                aria-describedby="textareaExplain" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight (Bobot)</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="weight" name="weight"
                                    aria-describedby="inputExplain" required>
                                <span class="input-group-text">%</span><br>
                            </div>
                            <div id="inputExplain" class="form-text">Number input only, example: 20 (will be 20%).</div>
                        </div>
                        <div class="mb-3">
                            <label for="target_type" class="form-label">Target Type</label>
                            <select id="target_type" class="form-select" name="target_type" required>
                                <option value="">Select Type</option>
                                <option value="Precentage">Precentage (%)</option>
                                <option value="Number">Number (123)</option>
                                <option value="Rupiah">Rupiah (Rp.)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="number" class="form-control" id="target" name="target"
                                aria-describedby="inputExplain" required>
                            <div id="inputExplain" class="form-text">Number input only, example: 20 (will be 20%).</div>
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">PIC (Person In Charge)</label>
                            <select id="user" class="form-select" name="user_id" required>
                                <option value="">Select Staff</option>
                                @foreach ($users as $userId => $user)
                                <option value="{{ $userId }}">{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('init.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection