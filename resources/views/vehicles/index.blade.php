@extends('adminlayout')
@section('title', 'AdminConsole')
@section('content')

    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <!-- Your existing navbar code -->

        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <!-- Your existing sidebar code -->

            <!-- Main content starts here -->
            <div class="container mt-5">
                <h1 class="text-center mb-4">All Vehicles</h1>

                @if($vehicles->isEmpty())
                    <div class="alert alert-warning text-center">
                        <p>No vehicles found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Vehicle Number</th>
                                    <th>Model</th>
                                    <th>Year</th>
                                    <th>User</th>
                                    <th>Status</th>
                                    <th>Vehicle Book</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vehicles as $vehicle)
                                    <tr>
                    

                                        <!-- Vehicle Number -->
                                        <td>{{ $vehicle->vehicle_number }}</td>

                                        <!-- Vehicle Model -->
                                        <td>{{ $vehicle->model }}</td>

                                        <!-- Vehicle Year -->
                                        <td>{{ $vehicle->year }}</td>

                                        <!-- User Name -->
                                        <td>{{ $vehicle->user->name ?? 'N/A'}}</td>

                                        <td>{{ $vehicle->status }}</td>

                                        <!-- Vehicle Book -->
                                        <td class="text-center">
                                            @if($vehicle->vehicle_book_image)
                                                <a href="{{ url('storage/' .$vehicle->vehicle_book_image) }}" target="_blank" class="btn btn-info btn-sm">View Book</a>
                                            @else
                                                <p>No Book</p>
                                            @endif
                                        </td>


                                        <!-- Approve Button -->
                                        <td class="text-center">
                                            @if($vehicle->status === 'pending')
                                                <form action="{{ route('vehicles.approve', $vehicle->vehicle_number) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>Approved</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Include your JS and plugins here -->
    <style>
        .table {
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #343a40;
            color: #fff;
        }

        .table td img {
            border-radius: 8px;
        }

        h1 {
            color: #333;
            font-family: 'Roboto', sans-serif;
        }

        .btn {
            margin-top: 5px;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-warning {
            background-color: #ffc107;
        }

        .alert-warning {
            font-size: 18px;
        }

        .container {
            max-width: 1200px;
        }

        .table-responsive {
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
    </style>
@endsection
