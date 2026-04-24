<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Appointments</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>CityCare Medical Centre</h2>
    <h3>Daily Appointments Report - {{ $date }}</h3>

    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Department</th>
                <th>Time</th>
                <th>Status</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->patient?->first_name }} {{ $appointment->patient?->last_name }}</td>
                    <td>{{ $appointment->doctor?->first_name }} {{ $appointment->doctor?->last_name }}</td>
                    <td>{{ $appointment->department?->name }}</td>
                    <td>{{ substr($appointment->appointment_time,0,5) }} - {{ substr($appointment->end_time,0,5) }}</td>
                    <td>{{ ucfirst($appointment->status) }}</td>
                    <td>{{ $appointment->reason }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>