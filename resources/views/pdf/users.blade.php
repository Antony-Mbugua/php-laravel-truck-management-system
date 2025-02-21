<!DOCTYPE html>
<html>
<head>
    <title>User Fleet Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        img {
            max-width: 80px;
            height: auto;
            display: block;
            margin: auto;
            border-radius: 8px;
            border: 2px solid #ddd;
        }
        .no-photo {
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1> Users Information</h1>
    <table>
        <thead>
            <tr>
                <th>Profile Photo</th>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>
                    @if($user->profile_photo_path)
                        <img src="{{ public_path('storage/' . $user->profile_photo_path) }}" alt="User Profile Photo">
                    @else
                        <span class="no-photo">No Photo</span>
                    @endif
                </td>
                <td><strong>{{ $user->id }}</strong></td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td><strong style="color: #28a745;">{{ ucfirst($user->role) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
