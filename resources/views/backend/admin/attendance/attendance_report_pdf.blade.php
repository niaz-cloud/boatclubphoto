<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Attendance Report</h2>

<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Class</th>
            <th>Roll</th>
            <th>Student</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $row)
            <tr>
                <td>{{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}</td>
                <td>{{ $row->class->class_name ?? '-' }}</td>
                <td>{{ $row->student->roll_number ?? '' }}</td>
                <td>{{ $row->student->name ?? '-' }}</td>
                <td>{{ ucfirst($row->status) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align:center;">No data found</td>
            </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
