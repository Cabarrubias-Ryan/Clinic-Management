<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medical Records</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #444;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e0e0e0;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Medical Records</h2>

    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Patient Email</th>
                <th>Patient Phone</th>
                <th>Patient Address</th>
                <th>Diagnosis</th>
                <th>Medication</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record['first_name'] }} {{ $record['last_name'] }}</td>
                    <td>{{ $record['email'] }}</td>
                    <td>{{ $record['phone_number'] }}</td>
                    <td>{{ $record['address'] }}</td>
                    <td>{{ $record['diagnosis'] }}</td>
                    <td>{{ $record['treatment'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($record['record_date'])->format('F d, Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
