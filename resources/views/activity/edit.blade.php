@extends('layouts.manager')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold my-4">Edit Kegiatan</h5>
            <form action="{{ route('act.update', $activity->id) }}" method="post">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" class="form-select" name="status">
                        <option value="Wildly Important Goal (WIG)" {{ old('status', $activity->status) === 'Wildly Important Goal (WIG)' ? 'selected' : '' }}>Wildly Important Goal (WIG)</option>
                        <option value="Important Goal (IG)" {{ old('status', $activity->status) === 'Important Goal (IG)' ? 'selected' : '' }}>Important Goal (IG)</option>
                    </select>
                    @error('status')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="objective" class="form-label">Tujuan</label>
                    <textarea class="form-control" id="objective" name="objective" aria-describedby="textareaExplain">{{ old('objective', $activity->objective) }}</textarea>
                    @error('objective')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="weight" class="form-label">Bobot</label>
                    <input type="number" class="form-control" id="weight" name="weight" aria-describedby="inputExplain" value="{{ old('weight', $activity->weight) }}">
                    <div id="inputExplain" class="form-text">Input angka saja, contoh: 20 (akan menjadi 20%).</div>
                    @error('weight')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="target_type" class="form-label">Jenis Target</label>
                    <select id="target_type" class="form-select" name="target_type">
                        <option value="Percentage" {{ old('target_type', $activity->target_type) === 'Percentage' ? 'selected' : '' }}>Persentase (%)</option>
                        <option value="Number" {{ old('target_type', $activity->target_type) === 'Number' ? 'selected' : '' }}>Angka (123)</option>
                        <option value="Rupiah" {{ old('target_type', $activity->target_type) === 'Rupiah' ? 'selected' : '' }}>Rupiah (Rp.)</option>
                    </select>
                    @error('target_type')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="target" class="form-label">Target</label>
                    <input type="number" class="form-control" id="target" name="target" aria-describedby="inputExplain" value="{{ old('target', $activity->target) }}">
                    <div id="inputExplain" class="form-text">Input angka saja, contoh: 20 (akan menjadi 20%).</div>
                    @error('target')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </form>
        </div>
    </div>
</div>
@endsection
