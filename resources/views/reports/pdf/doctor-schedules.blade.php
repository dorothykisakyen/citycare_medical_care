<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor Schedules Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>CityCare Medical Centre</h2>
    <h3>Doctor Schedules Report</h3>

    <table>
        <thead>
            <tr>
                <th>Doctor No.</th>
                <th>Doctor Name</th>
                <th>Department</th>
                <th>Day</th>
                <th>Start</th>
                <th>End</th>
                <th>Slot Duration</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->doctor?->doctor_number }}</td>
                    <td>{{ $schedule->doctor?->first_name }} {{ $schedule->doctor?->last_name }}</td>
                    <td>{{ $schedule->doctor?->department?->name }}</td>
                    <td>{{ $schedule->day_of_week }}</td>
                    <td>{{ $schedule->start_time }}</td>
                    <td>{{ $schedule->end_time }}</td>
                    <td>{{ $schedule->slot_duration }} min</td>
                    <td>{{ $schedule->is_available ? 'Available' : 'Not Available' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>