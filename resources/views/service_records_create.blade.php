@extends('adminlayout')
@section('title', 'AdminConsole')
@section('content')

    <div class="container-scroller">

        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <a class="navbar-brand brand-logo me-5" href="index.html"><img src="/Images/WhatsApp_Image_2024-08-17_at_11.34.32_490555d1-removebg-preview.png" class="me-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="index.html"><img src="/Images/WhatsApp_Image_2024-08-17_at_11.34.32_490555d1-removebg-preview.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
            <span class="input-group-text" id="search">
              <i class="fas fa-search"></i>
            </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="fas fa-info-circle mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">Application Error</h6>
                                    <p class="font-weight-light small-text mb-0 text-muted"> Just now </p>
                                </div>
                            </a>

                            <a class="dropdown-item preview-item" href="{{ route('admin.register') }}">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-info">
                                        <i class="fas fa-user mx-0"></i>
                                    </div>
                                </div>
                                <div class="preview-item-content">
                                    <h6 class="preview-subject font-weight-normal">New user registration</h6>
                                </div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="/images/face28.jpg" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-power-off text-primary"></i> Logout
                                </button>
                            </form>
                        </div>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('admin')}}">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Bookings</span>


                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Branches</span>


                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('branches.index') }}">View Branches</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('branches.create') }}">New Branches</a></li>

                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements1" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Services</span>


                        </a>
                        <div class="collapse" id="form-elements1">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('service.index') }}">View Services</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('service.create') }}">New Service</a></li>

                            </ul>
                        </div>
                    </li>

                   

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Service Record</span>

                        </a>
                        <div class="collapse" id="form">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('service_records.create') }}">Service Details</a></li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form1" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Vehicles</span>

                        </a>
                        <div class="collapse" id="form1">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('vehicle.index') }}">Vehicles Registered</a></li>


                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#form2" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Customers</span>

                        </a>
                        <div class="collapse" id="form2">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}">Customers Registerd</a></li>


                            </ul>
                        </div>
                    </li>


                </ul>
            </nav>
                <!-- partial -->
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

                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script src="/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
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
    <!-- plugins:js -->
    <script src="/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/vendors/chart.js/chart.umd.js"></script>
    <script src="/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/js/off-canvas.js"></script>
    <script src="/js/template.js"></script>
    <script src="/js/settings.js"></script>
    <script src="/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="/js/dashboard.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->

@endsection