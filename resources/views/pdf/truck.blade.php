<!DOCTYPE html>
<html>
<head>
    <title>Truck {{ $truck->license_plate }}</title>
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
            font-size: 24px;
            margin-bottom: 20px;
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
            max-width: 300px;
            height: auto;
            display: block;
            margin: 20px auto;
            border-radius: 8px;
            border: 3px solid #ddd;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        }
        .no-photo {
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>
    <h1>Truck Info</h1>

    @if($truck->photo)
        <img src="{{ public_path('storage/' . $truck->photo) }}" alt="Truck Photo">
    @else
        <p class="no-photo">No photo available</p>
    @endif

    <table>
        <tr><th>ID:</th><td>{{ $truck->id }}</td></tr>
        <tr><th>License Plate:</th><td>{{ $truck->license_plate }}</td></tr>
        <tr><th>Model:</th><td>{{ $truck->model }}</td></tr>
        <tr><th>Manufacturer:</th><td>{{ $truck->manufacturer }}</td></tr>
        <tr><th>Year:</th><td style="color: #28a745;">{{ $truck->year }}</td></tr>
    </table>
</body>
</html>
