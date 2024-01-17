@extends($layout)

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Dashboard</h5>
            @if (Auth::user()->divisi_id === 1)
            <p class="mb-0">This is a dashboard manager </p>
            @else
            <p class="mb-0">This is a dashboard staff </p>
            @endif
        </div>
    </div>
</div>
@endsection