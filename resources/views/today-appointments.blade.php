@extends('adminlayout')
@section('title', 'Appointment')
@section('content')

    <div class="container">
        <h1>Today's Appointments</h1>

        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @endif

        @if ($appointments->isEmpty())
            <p>No appointments for today.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Service Type</th>
                    <th>Branch</th>
                    <th>Vehicle Number</th>
                    <th>User</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>{{ $appointment->status }}</td>
                        <td>{{ $appointment->service->service_name ?? 'N/A' }}</td>
                        <td>{{ $appointment->branch->branch_name ?? 'N/A' }}</td>
                        <td>{{ $appointment->vehicle_number }}</td>
                        <td>{{ $appointment->user->name ?? 'N/A' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
