<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ get_setting('site_name') }} - Product List</title>
    <style>
        body {
            font-family: 'Open Sans', Arial, sans-serif;
            font-size: 16px;
            color: #444;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 1000px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #007665;
            padding-bottom: 20px;
        }
        .header img {
            height: 80px;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 32px;
            font-weight: bold;
            color: #007665;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 18px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            border-radius: 10px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 16px;
            text-align: left;
        }
        th {
            background-color: #007665;
            color: white;
            text-transform: uppercase;
            font-size: 14px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
            transition: 0.3s ease-in-out;
        }
        .footer {
            text-align: center;
            font-size: 16px;
            color: #555;
            margin-top: 40px;
            border-top: 2px solid #ddd;
            padding-top: 20px;
        }
        .footer a {
            color: #007665;
            font-weight: bold;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .contact-info {
            text-align: center;
            margin-top: 30px;
            font-size: 18px;
            color: #444;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 10px 15px;
            color: #ffffff;
            background-color: #007665;
            padding: 12px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }
        .social-links a:hover {
            background-color: #007665;
        }
        .company-info {
            text-align: center;
            font-size: 18px;
            color: #333;
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $logo = get_setting('header_logo');
            $site_name = get_setting('site_name');
            $site_url = url('/');
            $contact_phone = get_setting('contact_phone');
            $contact_facebook = get_setting('contact_facebook');
            $contact_instagram = get_setting('contact_instagram');
        @endphp

        <div class="header">
            <img src="{{ $logo ? uploaded_asset($logo) : static_asset('assets/img/logo.png') }}" alt="Store Logo">
            <h1>Lakkta Souq</h1>
            <p>{{ translate('Explore all your available products in our store') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>{{ translate('Product Name') }}</th>
                    <th>{{ translate('Category') }}</th>
                    <th>{{ translate('Unit Price') }}</th>
                    <th>{{ translate('Status') }}</th>
                    <th>{{ translate('Product Link') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    @php
                        $encodedProductName = urlencode($product->name);
                        $productLink = "https://lakkta.com/seller/products?search={$encodedProductName}";
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->main_category->getTranslation('name') }}</td>
                        <td>{{ single_price($product->unit_price) }}</td>
                        <td>{{ $product->current_stock > 0 ? translate('Available') : translate('Sold Out') }}</td>
                        <td>
                            <a href="{{ $productLink }}" target="_blank" style="color: #007BFF; text-decoration: none;">
                                {{ translate('View Product') }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="footer">
            <p>{{ translate('Visit our website:') }} <a href="{{ $site_url }}" target="_blank">{{ $site_url }}</a></p>
        </div>

        <div class="contact-info">
            <p>{{ translate('For inquiries, contact us at:') }}</p>
            <p>{{ translate('Phone:') }} <strong>{{ $contact_phone }}</strong></p>
            <div class="">
                <a href="https://www.facebook.com/profile.php?id=61571441986849" target="_blank" style="color: #007665; text-decoration: none;">{{ translate('Facebook') }}</a>
                |
                <a href="https://www.instagram.com/lakktasouq?igsh=dXljYWVkemFhOHll" target="_blank" style="color: #007665; text-decoration: none;">{{ translate('Instagram') }}</a>
            </div>
        </div>
        

        <div class="company-info" style="position: fixed; bottom: 10px; width: 100%; text-align: center; font-size: 12px; color: #777;">
            <p>&copy; {{ date('Y') }} {{ $site_name }}. {{ translate('All rights reserved.') }}</p>
        </div>        
    </div>
</body>
</html>
