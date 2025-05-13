@extends('layouts.main')

@section('content')
    <div class="row">
        <!-- Quick stats boxes -->
        <div class="col-lg-3">
            <!-- Members online -->
            <div class="card bg-teal text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-10">{{ $barangs }}</h3>
                    </div>

                    <div>
                        Barang
                    </div>
                </div>

            </div>
            <!-- /members online -->

        </div>


        @can('view_jenis_barang')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $jenisbarangs }}</h3>
                        </div>

                        <div>
                            Jenis Barang
                        </div>
                    </div>
                </div>
                <!-- /members online -->

            </div>
        @endcan

        <div class="col-lg-3">
            <!-- Current server load -->
            <div class="card bg-pink text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-10">{{ $transaksis }}</h3>
                        <div class="dropdown d-inline-flex ms-auto">
                            <a href="#" class="text-white d-inline-flex align-items-center dropdown-toggle"
                                data-bs-toggle="dropdown">
                                <i class="ph-gear"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="#" class="dropdown-item">
                                    <i class="ph-chart-line me-2"></i>
                                    Statistics
                                </a>

                            </div>
                        </div>
                    </div>

                    <div>
                        Transaksi
                    </div>
                </div>

                <div class="rounded-bottom overflow-hidden" id="server-load"></div>
            </div>
            <!-- /current server load -->

        </div>

        @can('view_satuan')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $satuans }}</h3>
                        </div>

                        <div>
                            Satuan
                        </div>
                    </div>
                </div>
                <!-- /members online -->
            </div>
        @endcan

        @can('view_user')
            <div class="col-lg-3">
                <!-- Members nline -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $users }}</h3>
                        </div>

                        <div>
                            User
                        </div>
                    </div>
                </div>
                <!-- /members online -->
            </div>
        @endcan
        @can('view_gudang')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $gudangs }}</h3>
                        </div>

                        <div>
                            Gudang
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('view_role')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $roles }}</h3>
                        </div>

                        <div>
                            Role
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('view_transaction_type')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $transactionType }}</h3>
                        </div>

                        <div>
                            Jenis Transaksi
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('view_category_barang')
            <div class="col-lg-3">
                <!-- Members online -->
                <div class="card bg-teal text-white">
                    <div class="card-body">
                        <div class="d-flex">
                            <h3 class="mb-10">{{ $barang_category }}</h3>
                        </div>

                        <div>
                            Kategori Barang
                        </div>
                    </div>
                </div>
            </div>
        @endcan

            <div class="col-lg-8">
                <!-- Card with Chart -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Grafik Transaksi</h5>
                    </div>
                    <div class="card-body">
                        <!-- Filter Dropdowns -->
                        <div class="filters mb-4">
                            <select id="yearFilter" class="form-control mb-2">
                                <option value="">Semua Tahun</option>
                            </select>

                            <select id="monthFilter" class="form-control">
                                <option value="">Semua Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>

                        <!-- Chart Canvas -->
                        <div style="position: relative; height: 400px; width: 100%;">
                            <canvas id="transaksiChart"></canvas>
                        </div>
                    </div>
                </div>


        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Transaksi</h5>
                </div>

                <div class="card-body">
                    <div class="fullcalendar-event-colors"></div>
                </div>
                <!-- /event colors -->
            </div>
        </div>
    </div>

            {{-- <!-- /progress counters -->

                <!-- Daily financials -->
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="mb-0">Daily financials</h5>
                        <div class="ms-auto">
                            <label class="form-check form-switch form-check-reverse">
                                <input type="checkbox" class="form-check-input" id="realtime" checked>
                                <span class="form-check-label">Realtime</span>
                            </label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart mb-3" id="bullets"></div>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-pink bg-opacity-10 text-pink lh-1 rounded-pill p-2">
                                    <i class="ph-chart-line"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                Stats for July, 6: <span class="fw-semibold">1938</span> orders, $4220 revenue
                                <div class="text-muted fs-sm">2 hours ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-success bg-opacity-10 text-success lh-1 rounded-pill p-2">
                                    <i class="ph-check"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                Invoices <a href="#">#4732</a> and <a href="#">#4734</a> have been
                                paid
                                <div class="text-muted fs-sm">Dec 18, 18:36</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-primary bg-opacity-10 text-primary lh-1 rounded-pill p-2">
                                    <i class="ph-users"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                Affiliate commission for June has been paid
                                <div class="text-muted fs-sm">36 minutes ago</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <div class="bg-warning bg-opacity-10 text-warning lh-1 rounded-pill p-2">
                                    <i class="ph-arrow-counter-clockwise"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                Order <a href="#">#37745</a> from July, 1st has been refunded
                                <div class="text-muted fs-sm">4 minutes ago</div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="me-3">
                                <div class="bg-teal bg-opacity-10 text-teal lh-1 rounded-pill p-2">
                                    <i class="ph-arrow-bend-double-up-right"></i>
                                </div>
                            </div>
                            <div class="flex-fill">
                                Invoice <a href="#">#4769</a> has been sent to <a href="#">Robert
                                    Smith</a>
                                <div class="text-muted fs-sm">Dec 12, 05:46</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /daily financials --> --}}

        </div>
    </div>
    <!-- /dashboard content -->
    {{-- @include('components.demo_config') --}}

    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const summaryByType = @json($summaryByType);
        const allDates = @json($allDates);
        const colors = ['#4BC0C0', '#FF6384', '#FFCE56', '#36A2EB']; // debit, credit, topup, withdraw
        const typeList = Object.keys(summaryByType);

        const yearFilter = document.getElementById('yearFilter');
        const monthFilter = document.getElementById('monthFilter');

        const tahunSet = new Set(allDates.map(date => date.substring(0, 4)));
        [...tahunSet].sort().forEach(tahun => {
            const opt = document.createElement('option');
            opt.value = tahun;
            opt.textContent = tahun;
            yearFilter.appendChild(opt);
        });

        let chart;

        function createChart(labels, datasets) {
            const ctx = document.getElementById('transaksiChart').getContext('2d');
            return new Chart(ctx, {
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: 'Grafik transaksi',
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            position: 'bottom',
                            onClick: (e, legendItem, legend) => {
                                const index = legendItem.datasetIndex;
                                const ci = legend.chart;
                                const meta = ci.getDatasetMeta(index);
                                // Toggle all datasets with the same label (bar+line)
                                const label = ci.data.datasets[index].labelBase;
                                ci.data.datasets.forEach((ds, i) => {
                                    if (ds.labelBase === label) {
                                        const meta = ci.getDatasetMeta(i);
                                        meta.hidden = !meta.hidden;
                                    }
                                });
                                ci.update();
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    interaction: {
                        mode: 'nearest',
                        axis: 'x',
                        intersect: false
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Tanggal'
                            },
                            ticks: {
                                maxRotation: 90,
                                minRotation: 45
                            },
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Transaksi'
                            },
                            grid: {
                                color: '#eee'
                            }
                        }
                    }
                }
            });
        }

        function getFilteredData(year, month) {
            return allDates.filter(date => {
                const y = date.substring(0, 4);
                const m = date.substring(5, 7);
                return (!year || y === year) && (!month || m === month);
            });
        }

        function generateDatasets(filteredDates) {
            const datasets = [];

            typeList.forEach((type, index) => {
                const data = summaryByType[type];

                const color = colors[index % colors.length];

                // Gabungkan data Bar dan Line dengan satu label yang sama
                datasets.push({
                    label: `${type} (line)`,
                    labelBase: type,
                    data: filteredDates.map(date => data[date] || 0),
                    backgroundColor: color,
                    borderColor: color,
                    borderWidth: 2,
                    barThickness: 8,
                    tension: 0.4,
                    fill: false,
                    pointRadius: 3,
                    type: 'line', // Bar dan Line digabung jadi satu
                });

                datasets.push({
                    label: `${type} (Bar)`,
                    labelBase: type,
                    data: filteredDates.map(date => data[date] || 0),
                    backgroundColor: color,
                    barThickness: 8,
                    type: 'bar',
                });
            });

            return datasets;
        }

        function updateChart() {
            const year = yearFilter.value;
            const month = monthFilter.value;
            const filteredDates = getFilteredData(year, month);
            const datasets = generateDatasets(filteredDates);

            chart.data.labels = filteredDates;
            chart.data.datasets = datasets;
            chart.update();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const datasets = generateDatasets(allDates);
            chart = createChart(allDates, datasets);

            yearFilter.addEventListener('change', updateChart);
            monthFilter.addEventListener('change', updateChart);
        });
    </script>
@endpush
