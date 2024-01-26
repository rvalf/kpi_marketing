<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KPI Marketing</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include html2pdf.js -->
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <!-- Internal Styles -->
    <style>
    /* Add your inline styles here */
    .text-primary {
        color: #007bff !important;
    }

    .fw-bolder {
        font-weight: bolder !important;
    }

    .mb-2 {
        margin-bottom: 0.5rem !important;
    }

    /* Add more styles as needed */
    </style>
</head>

<body>
    <div class="container-fluid">
        <h5 class="card-title fw-bolder">Score Board Utama</h5>

        @foreach ($actWIG as $act)
        <div class="card border-grey shadow mb-3">
            <div class="card-body py-3 px-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="mb-2">
                                    <p class="text-primary fw-bolder mb-1" style="font-size: 11px">
                                        {{ $act->status }}
                                    </p>
                                    <p class="fw-bolder" style="font-size: 18px">
                                        {{ $act->objective }}</p>
                                </div>
                            </div>
                            <div class="col-sm-2 text-end">
                                <div class="mb-2">
                                    <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Weight
                                    </p>
                                    <p class="fw-bold">{{ $act->weight }} %</p>
                                </div>
                            </div>
                            <div class="col-sm-2 text-end">
                                <div class="mb-2">
                                    <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target
                                    </p>
                                    @if ($act->target_type == 'Precentage')
                                    <p class="fw-bold">{{ $act->target }} %</p>
                                    @elseif ($act->target_type == 'Rupiah')
                                    <p class="fw-bold rupiah">Rp.
                                        {{ number_format($act->target, 0, ',', '.') }}
                                    </p>
                                    @else
                                    <p class="fw-bold">{{ $act->target }} %</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example"
                            aria-valuenow="{{ $progresActWIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100"
                            style="height: 20px">
                            <div class="progress-bar bg-primary" style="width: {{ $progresActWIG[$act->id] }}%;">
                                {{ $progresActWIG[$act->id] }}%
                            </div>
                        </div>
                        <table class="table table-sm table-bordered table-hover mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="30">No</th>
                                    <th scope="col">Initiatives</th>
                                    <th scope="col" class="text-end">Weight</th>
                                    <th scope="col" class="text-end">Target</th>
                                    <th scope="col" class="text-end">Actual</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($act->initiatives as $init)
                                <tr>
                                    <td class="text-center">{{ $loop->index+1 }}</td>
                                    <td>{{ $init->initiative }}</td>
                                    <td class="text-end">{{ $init->weight }}%</td>
                                    @if ($init->target_type == 'Precentage')
                                    <td class="text-end">{{ $init->target }} %</td>
                                    @elseif ($init->target_type == 'Rupiah')
                                    <td class="text-end formattedValue">{{ $init->target }}</td>
                                    @else
                                    <td class="text-end">{{ $init->target }}</td>
                                    @endif
                                    @if ($init->reports && $lastReport = $init->reports->last())
                                    @if ($init->target_type == 'Precentage')
                                    <td class="text-end">{{ $lastReport->actual }} %</td>
                                    @elseif ($init->target_type == 'Rupiah')
                                    <td class="text-end formattedValue">{{ $lastReport->actual }}</td>
                                    @else
                                    <td class="text-end">{{ $lastReport->actual }}</td>
                                    @endif
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 mt-3" style="padding-left:50px">
                        <h6>Presentase <span class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                                style="background-color: #e6e3e3">Plan</span> vs
                            <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder">Actual</span>
                        </h6>
                        <div class="mt-3">
                            <div id="chartActivityWIG_{{ $loop->index }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @foreach ($actIG as $act)
        <div class="card border-grey shadow mb-3">
            <div class="card-body py-3 px-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="mb-2">
                                    <p class="text-warning fw-bolder mb-1" style="font-size: 11px">
                                        {{ $act->status }}
                                    </p>
                                    <p class="fw-bolder" style="font-size: 18px">
                                        {{ $act->objective }}</p>
                                </div>
                            </div>
                            <div class="col-sm-2 text-end">
                                <div class="mb-2">
                                    <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Weight
                                    </p>
                                    <p class="fw-bold">{{ $act->weight }} %</p>
                                </div>
                            </div>
                            <div class="col-sm-2 text-end">
                                <div class="mb-2">
                                    <p class="text-primary fw-bolder mb-1" style="font-size: 11px">Target
                                    </p>
                                    @if ($act->target_type == 'Precentage')
                                    <p class="fw-bold">{{ $act->target }} %</p>
                                    @elseif ($act->target_type == 'Rupiah')
                                    <p class="fw-bold rupiah">Rp.
                                        {{ number_format($act->target, 0, ',', '.') }}
                                    </p>
                                    @else
                                    <p class="fw-bold">{{ $act->target }} %</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="progress" role="progressbar" aria-label="Success example"
                            aria-valuenow="{{ $progresActIG[$act->id] }}" aria-valuemin="0" aria-valuemax="100"
                            style="height: 20px">
                            <div class="progress-bar bg-primary" style="width: {{ $progresActIG[$act->id] }}%;">
                                {{ $progresActIG[$act->id] }}%
                            </div>
                        </div>
                        <table class="table table-sm table-bordered table-hover mt-3">
                            <thead>
                                <tr>
                                    <th scope="col" width="30">No</th>
                                    <th scope="col">Initiatives</th>
                                    <th scope="col" class="text-end">Weight</th>
                                    <th scope="col" class="text-end">Target</th>
                                    <th scope="col" class="text-end">Actual</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @foreach ($act->initiatives as $init)
                                <tr>
                                    <td class="text-center">{{ $loop->index+1 }}</td>
                                    <td>{{ $init->initiative }}</td>
                                    <td class="text-end">{{ $init->weight }}%</td>
                                    @if ($init->target_type == 'Precentage')
                                    <td class="text-end">{{ $init->target }} %</td>
                                    @elseif ($init->target_type == 'Rupiah')
                                    <td class="text-end formattedValue">{{ $init->target }}</td>
                                    @else
                                    <td class="text-end">{{ $init->target }}</td>
                                    @endif
                                    @if ($init->reports && $lastReport = $init->reports->last())
                                    @if ($init->target_type == 'Precentage')
                                    <td class="text-end">{{ $lastReport->actual }} %</td>
                                    @elseif ($init->target_type == 'Rupiah')
                                    <td class="text-end formattedValue">{{ $lastReport->actual }}</td>
                                    @else
                                    <td class="text-end">{{ $lastReport->actual }}</td>
                                    @endif
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-6 mt-3" style="padding-left:50px">
                        <h6>Presentase <span class="badge rounded-3 px-2 mx-2 text-dark fw-bolder"
                                style="background-color: #e6e3e3">Plan</span> vs
                            <span class="badge rounded-3 px-2 mx-2 bg-primary fw-bolder">Actual</span>
                        </h6>
                        <div class="mt-3">
                            <div id="chartActivityIG_{{ $loop->index }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <button id="exportButton">Export to PDF</button>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
    $(document).ready(function() {
        var elements = document.getElementsByClassName('formattedValue');

        // Iterate over each element and format its content
        for (var i = 0; i < elements.length; i++) {
            var rawValue = parseInt(elements[i].innerText); // Parse the value as an integer

            // Use Numeral.js to format the value
            var formattedValue;

            if (rawValue >= 1000000000) {
                formattedValue = numeral(rawValue / 1000000000).format('0.0a').toUpperCase() + 'B';
            } else if (rawValue >= 1000000) {
                formattedValue = numeral(rawValue / 1000000).format('0.0a').toUpperCase() + 'M';
            } else if (rawValue >= 1000) {
                formattedValue = numeral(rawValue / 1000).format('0.0a').toUpperCase() + 'K';
            } else {
                formattedValue = rawValue;
            }

            // Update the element with the formatted value
            elements[i].innerText = formattedValue;
        }
    });

    document.getElementById('exportButton').addEventListener('click', function() {
        // Options for pdf export
        const options = {
            margin: 10,
            filename: 'exported-document.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        // Get the container element (change this to match your container)
        const element = document.querySelector('.container-fluid');

        // Use html2pdf.js to export the HTML content to PDF
        html2pdf(element, options);
    });
    </script>
</body>

</html>