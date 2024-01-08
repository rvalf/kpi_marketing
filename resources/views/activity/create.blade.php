@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Add New Activity</h5>
            <form action="{{ route('act.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" class="form-select" name="status">
                        <option value="">Select Status</option>\
                        <option value="Wildly Important Goal (WIG)">Wildly Important Goal (WIG)</option>
                        <option value="Important Goal (IG)">Important Goal (IG)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="objective" class="form-label">Objective</label>
                    <textarea class="form-control" id="objective" name="objective" aria-describedby="textareaExplain"></textarea>
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (Bobot)</label>
                    <input type="number" class="form-control" id="weight" name="weight" aria-describedby="inputExplain">
                    <div id="inputExplain" class="form-text">number input only, example: 20 (will be 20%).</div>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Target Type</label>
                    <select id="status" class="form-select" name="status">
                        <option value="">Select Type</option>\
                        <option value="Precentage">Precentage (%)</option>
                        <option value="Number">Number (123)</option>
                        <option value="Rupiah">Rupiah (Rp.)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="target" class="form-label">Target</label>
                    <input type="number" class="form-control" id="target" name="target" aria-describedby="inputExplain">
                    <div id="inputExplain" class="form-text">number input only, example: 20 (will be 20%).</div>
                </div>
                <input type="submit" class="btn btn-primary"></input>
            </form>
        </div>
    </div>
</div>
@endsection