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
                        <a class="nav-link" data-bs-toggle="collapse" href="#form-elements2" aria-expanded="false" aria-controls="form-elements">
                            <i class="fas fa-th-large menu-icon"></i>
                            <span class="menu-title">Sub-Services</span>


                        </a>
                        <div class="collapse" id="form-elements2">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="{{ route('branches.index') }}">View Branches</a></li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('branches.create') }}">New Branches</a></li>

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


                </ul>
            </nav>
            <!-- partial -->
            <div class="container">
                <h1 class="my-4">Services</h1>
                <a href="{{ route('service.create') }}" class="btn btn-primary mb-3">Add New Service</a>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <td>{{ $service->ServiceTypeId }}</td>
                            <td>{{ $service->ServiceTypeName }}</td>
                            <td>
                                <a href="{{ route('service.show', $service->ServiceTypeId) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('service.edit', $service->ServiceTypeId) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('service.destroy', $service->ServiceTypeId) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
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
