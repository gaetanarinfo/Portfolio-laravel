@if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
    </div>
@endif

<a href="{{ route('make.payment') }}" class="btn btn-theme">Pay from Paypal</a>
