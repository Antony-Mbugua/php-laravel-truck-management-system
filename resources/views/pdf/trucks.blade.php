<!DOCTYPE html>
<html>
<head>
    <title>Truck Fleet Report</title>
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
            max-width: 100px;
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
    <h1>Truck Fleet Information</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>License Plate</th>
                <th>Model</th>
                <th>Manufacturer</th>
                <th>Year</th>
                <th>Photo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trucks as $truck)
            <tr>
                <td><strong>{{ $truck->id }}</strong></td>
                <td>{{ $truck->license_plate }}</td>
                <td>{{ $truck->model }}</td>
                <td>{{ $truck->manufacturer }}</td>
                <td><strong style="color: #28a745;">{{ $truck->year }}</strong></td>
                <td>
                    @if($truck->photo)
                        <img src="{{ public_path('storage/' . $truck->photo) }}" alt="Truck Photo">
                    @else
                        <span class="no-photo">No Photo</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
