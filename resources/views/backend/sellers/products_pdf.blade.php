<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ get_setting('site_name') }} - Product List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            height: 60px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            margin: 0;
        }
        .header p {
            font-size: 14px;
            color: #777;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 30px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $logo = get_setting('header_logo');
            $site_name = get_setting('site_name');
            $site_url = url('/');
        @endphp

        <div class="header">
            <img src="{{ $logo ? uploaded_asset($logo) : static_asset('assets/img/logo.png') }}" alt="Store Logo">
            <h1>{{ $site_name }}</h1>
            <p>{{ translate('Here is the list of all products available in our store.') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th>Stock Quantity</th>
                    <th>Discount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category_id }} <!-- You can replace with category name if you have a relationship --></td>
                        <td>{{ single_price($product->unit_price) }}</td>
                        <td>{{ $product->current_stock }}</td>
                        <td>{{ $product->discount }}%</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>{{ translate('Visit our website:') }} <a href="{{ $site_url }}" target="_blank">{{ $site_url }}</a></p>
        </div>
    </div>
</body>
</html>
