<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patient Visits</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2>CityCare Medical Centre</h2>
    <h3>Patient Visits Report</h3>

    <table>
        <thead>
            <tr>
                <th>Patient No.</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Visit Count</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_number }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->appointments_count }}</td>
                    <td>{{ $patient->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>