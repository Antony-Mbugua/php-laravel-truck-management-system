<!DOCTYPE html>
<html>
<head>
    <title>AOL USER: {{ $user->first_name }} {{ $user->last_name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 26px;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        h2 {
            color: #007BFF;
            font-size: 22px;
            margin-top: 20px;
        }
        table {
            width: 60%;
            margin: auto;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        th {
            background-color: #007BFF;
            color: white;
            font-weight: bold;
            text-align: right;
            width: 40%;
        }
        td {
            text-align: left;
            font-weight: bold;
            color: #333;
            background-color: #f8f9fa;
        }
        img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 15px auto;
            border-radius: 50%;
            border: 3px solid #ddd;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        }
        .no-photo {
            color: #777;
            font-style: italic;
            font-size: 18px;
        }
        p {
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>User Info</h1>

    @if($user->profile_photo_path)
        <img src="{{ public_path('storage/' . $user->profile_photo_path) }}" alt="User Photo">
    @else
        <p class="no-photo">No profile photo available</p>
    @endif

    <table>
        <tr><th>ID:</th><td>{{ $user->id }}</td></tr>
        <tr><th>First Name:</th><td>{{ $user->first_name }}</td></tr>
        <tr><th>Last Name:</th><td>{{ $user->last_name }}</td></tr>
        <tr><th>Email:</th><td>{{ $user->email }}</td></tr>
        <tr><th>Phone Number:</th><td>{{ $user->phone }}</td></tr>
        <tr><th>Role:</th><td style="color: #28a745;">{{ $user->role }}</td></tr>
    </table>

    <h2> Company Remarks</h2>
    <p><strong>All Over Logistics:</strong> We Value You </p> 
</body>
</html>
