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

        <div class="col-lg-3">
            <!-- Current server load -->
            <div class="card bg-pink text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h3 class="mb-10">0</h3>
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
        <div class="col-lg-3">
            <!-- Members online -->
            <div class="card bg-teal text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-10">{{ $gudangs }}</h3>
                    </div>

                    <div>
                        Status
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <!-- Members online -->
            <div class="card bg-teal text-white">
                <div class="card-body">
                    <div class="d-flex">
                        <h3 class="mb-10">{{ $gudangs }}</h3>
                    </div>

                    <div>
                        Jenis Transaksi
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">

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
            <div class="col-xl-4">
                <!-- /progress counters -->

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
                <!-- /daily financials -->

            </div>
        </div>
        <!-- /dashboard content -->
    </div>
@endsection
