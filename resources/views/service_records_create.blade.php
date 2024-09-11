@extends('adminlayout')
@section('title', 'AdminConsole')
@section('content')

    <div class="container-scroller">
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <!-- Your navbar content -->
        </nav>

        <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <!-- Your sidebar content -->
            </nav>

            <div class="container">
                <h1 class="my-4">Enter Service Record</h1>

                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Bootstrap Tabs -->
                <ul class="nav nav-tabs" id="serviceRecordTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="vehicle-info-tab" data-bs-toggle="tab" href="#vehicle-info" role="tab" aria-controls="vehicle-info" aria-selected="true">Vehicle Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="oil-services-tab" data-bs-toggle="tab" href="#oil-services" role="tab" aria-controls="oil-services" aria-selected="false">Oil and Lubrication</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tire-services-tab" data-bs-toggle="tab" href="#tire-services" role="tab" aria-controls="tire-services" aria-selected="false">Tire and Wheel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="battery-services-tab" data-bs-toggle="tab" href="#battery-services" role="tab" aria-controls="battery-services" aria-selected="false">Battery and Electrical</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="cleaning-services-tab" data-bs-toggle="tab" href="#cleaning-services" role="tab" aria-controls="cleaning-services" aria-selected="false">Cleaning and Detailing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="mechanical-repair-tab" data-bs-toggle="tab" href="#mechanical-repair" role="tab" aria-controls="mechanical-repair" aria-selected="false">Mechanical Repair</a>
                    </li>
                </ul>

                <form action="{{ route('service_records.store') }}" method="POST">
                    @csrf

                    <!-- Tab Content -->
                    <div class="tab-content" id="serviceRecordTabsContent">
                        <!-- Vehicle Info -->
                        <div class="tab-pane fade show active" id="vehicle-info" role="tabpanel" aria-labelledby="vehicle-info-tab">
                            <div class="mb-3">
                                <label for="vehicle_number" class="form-label">Vehicle Number</label>
                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" required>
                            </div>

                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>

                            <div class="mb-3">
                                <label for="time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>

                            <div class="mb-3">
                                <label for="supervisor" class="form-label">Supervisor</label>
                                <select class="form-control" id="supervisor" name="supervisor" required>
                                    <option value="">Select Supervisor</option>
                                    @foreach($adminUsers as $adminUser)
                                        <option value="{{ $adminUser->name }}">{{ $adminUser->name }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="current_mileage" class="form-label">Current Mileage</label>
                                <input type="number" class="form-control" id="current_mileage" name="current_mileage" required>
                            </div>
                        </div>

                        <!-- Oil and Lubrication Services -->
                        <div class="tab-pane fade" id="oil-services" role="tabpanel" aria-labelledby="oil-services-tab">
                            <h4>Oil and Lubrication Services</h4>
                            @foreach(['engine_oil', 'clutch_oil', 'brake_oil', 'coolant', 'oil_filter'] as $service)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $service)) }}</label>
                                    <input type="text" class="form-control" id="{{ $service }}" name="{{ $service }}" value="{{ old($service, 'N/A') }}">
                                    <input type="number" class="form-control mt-1" id="{{ $service }}_change_mileage" name="{{ $service }}_change_mileage" placeholder="Change mileage (if applicable)" min="0">
                                </div>
                            @endforeach
                        </div>

                        <!-- Tire and Wheel Services -->
                        <div class="tab-pane fade" id="tire-services" role="tabpanel" aria-labelledby="tire-services-tab">
                            <h4>Tire and Wheel Services</h4>
                            @foreach(['tire_rotation', 'wheel_alignment'] as $service)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $service)) }}</label>
                                    <input type="text" class="form-control" id="{{ $service }}" name="{{ $service }}" value="{{ old($service, 'N/A') }}">
                                    <input type="number" class="form-control mt-1" id="{{ $service }}_change_mileage" name="{{ $service }}_change_mileage" placeholder="Change mileage (if applicable)" min="0">
                                </div>
                            @endforeach
                        </div>

                        <!-- Battery and Electrical Services -->
                        <div class="tab-pane fade" id="battery-services" role="tabpanel" aria-labelledby="battery-services-tab">
                            <h4>Battery and Electrical Services</h4>
                            @foreach(['battery_replacement', 'alternator_testing'] as $service)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $service)) }}</label>
                                    <input type="text" class="form-control" id="{{ $service }}" name="{{ $service }}" value="{{ old($service, 'N/A') }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Cleaning and Detailing Services -->
                        <div class="tab-pane fade" id="cleaning-services" role="tabpanel" aria-labelledby="cleaning-services-tab">
                            <h4>Cleaning and Detailing Services</h4>
                            @foreach(['exterior_car_wash', 'interior_vacuuming'] as $service)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $service)) }}</label>
                                    <input type="text" class="form-control" id="{{ $service }}" name="{{ $service }}" value="{{ old($service, 'N/A') }}">
                                </div>
                            @endforeach
                        </div>

                        <!-- Mechanical Repair Services -->
                        <div class="tab-pane fade" id="mechanical-repair" role="tabpanel" aria-labelledby="mechanical-repair-tab">
                            <h4>Mechanical Repair Services</h4>
                            @foreach(['brake_system_repair', 'suspension_repair'] as $service)
                                <div class="mb-3">
                                    <label class="form-label">{{ ucfirst(str_replace('_', ' ', $service)) }}</label>
                                    <input type="text" class="form-control" id="{{ $service }}" name="{{ $service }}" value="{{ old($service, 'N/A') }}">
                                    <input type="number" class="form-control mt-1" id="{{ $service }}_mileage" name="{{ $service }}_mileage" placeholder="Change mileage (if applicable)" min="0">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var successMessage = "{{ session('success') }}";
            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: successMessage,
                });
            }
        });
    </script>

    <!-- Scripts -->
    <script src="/vendors/js/vendor.bundle.base.js"></script>
    <script src="/vendors/chart.js/chart.umd.js"></script>
    <script src="/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="/js/dataTables.select.min.js"></script>
    <script src="/js/off-canvas.js"></script>
    <script src="/js/template.js"></script>
    <script src="/js/settings.js"></script>
    <script src="/js/todolist.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
