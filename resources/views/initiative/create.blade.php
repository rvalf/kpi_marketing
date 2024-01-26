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
                        <input type="hidden" name="activity_id" value="{{ $act->id }}">
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
                <div class="col-sm-5 ps-4 border-start border-3">
                    <div class="border rounded-2 border-1 p-2 mb-3">
                        <p class="fw-bolder mb-1">{{ $act->objective }}</p>
                    </div>
                    <table class="table table-sm table-detail">
                        <thead>
                            <tr>
                                <th scope="col">Initiative</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Target</th>
                                <th scope="col">PIC</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($act->initiatives as $init)
                            <tr>
                                <td>{{ $init->initiative }}</td>
                                <td>{{ $init->weight }} %</td>
                                <td>{{ $init->target }} %</td>
                                <td>{{ $init->user->fullname }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection