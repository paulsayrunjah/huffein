<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Activity Log</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Log Name</th>
                <th>Description</th>
                <th>Subject</th>
                <th>Causer</th>
                <th>Properties</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activityLogs as $activityLog)
                <tr>
                    <td>{{ '' }}</td>
                    <td>{{ $activityLog->log_name }}</td>
                    <td>{{ $activityLog->description }}</td>
                    <td>{{ $activityLog->subject_id }}</td>
                    <td>{{ $activityLog->causer_id }}</td>
                    <td>{{ $activityLog->properties }}</td>
                    <td>{{ $activityLog->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>