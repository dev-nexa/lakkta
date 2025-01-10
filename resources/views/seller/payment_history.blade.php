{{-- This page was showing payment history and I will change it to payment information. --}}
{{-- @extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Payment History') }}</h5>
        </div>
        @if (count($payments) > 0)
            <div class="card-body">
                <table class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ translate('Date')}}</th>
                            <th>{{ translate('Amount')}}</th>
                            <th>{{ translate('Payment Method')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $key => $payment)
                            <tr>
                                <td>
                                    {{ $key+1 }}
                                </td>
                                <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                                <td>
                                    {{ single_price($payment->amount) }}
                                </td>
                                <td>
                                    {{ translate(ucfirst(str_replace('_', ' ', $payment->payment_method))) }} @if ($payment->txn_code != null) ({{  translate('TRX ID') }} : {{ $payment->txn_code }}) @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="aiz-pagination">
                	{{ $payments->links() }}
              	</div>
            </div>
        @endif
    </div>

@endsection --}}
@extends('seller.layouts.app')

@section('panel_content')
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{ translate('Payment Information') }}</h5>
        </div>
        <div class="card-body">
            <h6>{{ translate('Merchant Payment Information') }}</h6>
            <p>{{ translate('Payment Instructions') }}</p>
            <ul>
                <li>{{ translate('Payment via Al-Haram') }}: {{ translate('Account Number') }}: 123456789</li>
                <li>{{ translate('Payment via Al-Qadmus') }}: {{ translate('Account Number') }}: 234567890</li>
                <li>{{ translate('Payment via Al-Fouad') }}: {{ translate('Account Number') }}: 345678901</li>
                <li>{{ translate('Payment via Al-Baraka Bank') }}: {{ translate('Account Number') }}: 987654321</li>
                <li>{{ translate('Payment via Islamic Bank') }}: {{ translate('Account Number') }}: 456789012</li>
                <li>{{ translate('Payment via Al-Sham Bank') }}: {{ translate('Account Number') }}: 567890123</li>
            </ul>
            <p>{{ translate('Amount') }}: 25 {{ translate('USD per month') }}</p>
            <p>{{ translate('Please contact the support team at 0993329401 to confirm the payment process.') }}</p>
        </div>
        <div class="card-body">
            <h6>{{ translate('Individual Advertiser Payment Information') }}</h6>
            <p>{{ translate('Payment Instructions') }}</p>
            <ul>
                <li>{{ translate('Payment via Al-Haram') }}: {{ translate('Account Number') }}: 123456789</li>
                <li>{{ translate('Payment via Al-Qadmus') }}: {{ translate('Account Number') }}: 234567890</li>
                <li>{{ translate('Payment via Al-Fouad') }}: {{ translate('Account Number') }}: 345678901</li>
                <li>{{ translate('Payment via Al-Baraka Bank') }}: {{ translate('Account Number') }}: 987654321</li>
                <li>{{ translate('Payment via Islamic Bank') }}: {{ translate('Account Number') }}: 456789012</li>
                <li>{{ translate('Payment via Al-Sham Bank') }}: {{ translate('Account Number') }}: 567890123</li>
            </ul>
            <p>{{ translate('Amount') }}: 5 {{ translate('USD per post') }}</p>
            <p>{{ translate('Please contact the support team at 0993329401 to confirm the payment process.') }}</p>
        </div>
    </div>
@endsection

