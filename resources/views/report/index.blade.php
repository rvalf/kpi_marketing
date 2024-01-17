@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    @foreach ($inits as $init)
    <div class="card border-grey shadow mb-3">
        <div class="card-body py-3 px-4">
            <div class="row">
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-9 d-flex flex-column justify-content-center align-items-center">
                            <p class="badge text-primary fw-bolder mb-1" style="font-size: 11px">
                                {{ $init->activity->status }}
                            </p>
                            <p class="fw-bolder">{{ $init->activity->objective }}</p>
                        </div>
                        <div class="col-sm-3 d-flex flex-column align-items-center">
                            <p class="badge text-primary fw-bolder mb-1" style="font-size: 11px">Target</p>
                            @if ($init->target_type == 'Precentage')
                            <p class="fw-bold">{{ $init->target }} %</p>
                            @elseif ($init->target_type == 'Rupiah')
                            <p class="fw-bold">Rp. {{ number_format($init->target, 0, ',', '.') }}</p>
                            @else
                            <p class="fw-bold">{{ $init->target }} %</p>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="col-sm-7">
                    <div class="pb-1 font-11">
                        <div class="row g-3">
                            <div class="col-sm-1">
                                <div class="row">
                                    <div class="col px-1 text-center text-white bg-secondary border">YTD</div>
                                    <div class="col px-1 text-center border">Plan</div>
                                    <div class="col px-2 text-center border">Act</div>
                                    <div class="col px-3 text-center border">%</div>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <div class="d-flex">
                                    <div class="col border">
                                        <div class="col px-2 text-white bg-secondary border text-center">Jan</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">100</div>
                                    </div>
                                    <div class="col border">
                                        <div class="col px-2 text-white bg-secondary border text-center">Feb</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">100</div>
                                    </div>
                                    <div class="col border">
                                        <div class="col px-2 text-white bg-secondary border text-center">Mar</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">20 %</div>
                                        <div class="col px-2 border text-end">100</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div id="chart_{{ $loop->index }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection