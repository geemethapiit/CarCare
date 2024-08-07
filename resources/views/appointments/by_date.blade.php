<!DOCTYPE html>
<html>
<head>
    <title>Today's Appointments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .time-slot {
            background-color: #f9f9f9;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1>Appointments for Today</h1>
<table>
    <thead>
    <tr>
        <th>Time Slot</th>
        <th>Vehicle Number</th>
        <th>Service Type</th>
        <th>Branch</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($timeSlots as $timeSlot => $appointments)
        <tr class="time-slot">
            <td colspan="5">{{ $timeSlot }}</td>
        </tr>
        @foreach ($appointments as $appointment)
            <tr>
                <td></td>
                <td>{{ $appointment->vehicle_number }}</td>
                <td>{{ $appointment->ServiceTypeId }}</td>
                <td>{{ $appointment->BranchID }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
</body>
</html>
