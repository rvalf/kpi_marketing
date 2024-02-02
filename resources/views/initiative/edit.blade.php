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
                    <h5 class="card-title fw-semibold my-2">Edit Initiative</h5>
                    <form action="{{ route('init.update', $init->id) }}" method="post">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="activity_id" value="{{ $init->activity_id }}">
                        <div class="mb-3">
                            <label for="initiative" class="form-label">Initiative</label>
                            <textarea class="form-control" id="initiative" name="initiative"
                                aria-describedby="textareaExplain">{{ old('initiative', $init->initiative) }}</textarea>
                            @error('initiative')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="weight" class="form-label">Weight</label>
                            <div class="input-group w-50">
                                <input type="number" class="form-control" id="weight" name="weight"
                                    aria-describedby="inputExplain" value="{{ old('weight', $init->weight) }}">
                                <span class="input-group-text">%</span><br>
                            </div>
                            <div id="inputExplain" class="form-text">Number input only, example: 20 (will be 20%).</div>
                            @error('weight')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="target_type" class="form-label">Target Type</label>
                            <select id="target_type" class="form-select" name="target_type">
                                <option value="Precentage"
                                    {{ old('target_type', $init->target_type) === 'Percentage' ? 'selected' : '' }}>
                                    Precentage (%)</option>
                                <option value="Number"
                                    {{ old('target_type', $init->target_type) === 'Number' ? 'selected' : '' }}>
                                    Number (123)
                                </option>
                                <option value="Rupiah"
                                    {{ old('target_type', $init->target_type) === 'Rupiah' ? 'selected' : '' }}>
                                    Rupiah (Rp.)
                                </option>
                            </select>
                            @error('target_type')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="number" class="form-control" id="target" name="target"
                                aria-describedby="inputExplain" value="{{ old('target', $init->target) }}">
                            <div id="inputExplain" class="form-text">Number input only, example: 20 (will be 20%).</div>
                            @error('target')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="user" class="form-label">PIC (Person In Charge)</label>
                            <select id="user" class="form-select" name="user_id" required>
                                @foreach ($users as $userId => $user)
                                <option {{ $init->user_id == $userId ? 'selected' : '' }} value="{{ $userId }}">
                                    {{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <a href="{{ route('init.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
                <div class="col-sm-5 ps-4 border-start border-3">
                    <div class="border rounded-2 border-1 p-2 mb-3">
                        <p class="fw-bolder mb-1">{{ $init->activity->objective }}</p>
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
                            @php
                            $act = $init->activity;
                            @endphp
                            @foreach ($act->initiatives as $in)
                            <tr class="{{ $in->id === $init->id ? 'bg-success wig' : '' }}">
                                <td>{{ $in->initiative }}</td>
                                <td>{{ $in->weight }} %</td>
                                <td>{{ $in->target }} %</td>
                                <td>{{ $in->user->fullname }}</td>
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