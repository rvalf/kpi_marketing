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
                    <h5 class="card-title fw-semibold my-2">Add New Activity</h5>
                    <form action="{{ route('act.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" class="form-select" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Wildly Important Goal (WIG)">Wildly Important Goal (WIG)</option>
                                <option value="Important Goal (IG)">Important Goal (IG)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="objective" class="form-label">Objective</label>
                            <textarea class="form-control" id="objective" name="objective"
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
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('act.index') }}" class="btn btn-danger">Back</a>
                        </div>
                    </form>
                </div>
                <div class="col-sm-5 ps-4 border-start border-3">
                    <p class="fw-semibold my-2 p-1 px-2 bg-primary rounded-2 text-white" style="width: fit-content;">
                        Wildly Important Goal (WIG)</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Objective</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actsWIG as $act)
                            <tr>
                                <th scope="row">{{ $loop->index+1 }}</th>
                                <td>{{ $act->objective }}</td>
                                <td>{{ $act->weight }}%</td>
                                @if ($act->target_type === 'Precentage')
                                <td>{{ $act->target }}%</td>
                                @elseif ($act->target_type === 'Rupiah')
                                <td>Rp. {{ $act->target }}</td>
                                @else
                                <td>{{ $act->target }}</td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p class="fw-semibold my-2 p-1 px-2 bg-secondary rounded-2 text-white" style="width: fit-content;">
                        Important Goal (IG)</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Objective</th>
                                <th scope="col">Weight</th>
                                <th scope="col">Target</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actsIG as $act)
                            <tr>
                                <th scope="row">{{ $loop->index+1 }}</th>
                                <td>{{ $act->objective }}</td>
                                <td>{{ $act->weight }}%</td>
                                @if ($act->target_type === 'Precentage')
                                <td>{{ $act->target }}%</td>
                                @elseif ($act->target_type === 'Rupiah')
                                <td>Rp. {{ $act->target }}</td>
                                @else
                                <td>{{ $act->target }}</td>
                                @endif
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