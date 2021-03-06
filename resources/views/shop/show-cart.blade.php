@extends('layouts.app')

@section('template_title')
    Shop Now
@endsection

@section('template_fastload_css')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <p><a href="{{ url('shop') }}">Shop</a> / Cart</p>
            <h1>Your Cart</h1>

            <hr>

            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if (session()->has('error_message'))
                <div class="alert alert-danger">
                    {{ session()->get('error_message') }}
                </div>
            @endif

            @if (sizeof($items) > 0)

                <table class="table">
                    <thead>
                    <tr>
                        <th class="table-image"></th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th class="column-spacer"></th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="table-image"><a href="{{ url('shop', [$item['slug']]) }}"><img width="50px" height="50px"
                                            src="{{ $item['image'] }}" alt="product"
                                            class="img-responsive cart-image"></a></td>
                            <td><a href="{{ url('shop', [$item['slug']]) }}">{{ $item['name'] }}</a></td>
                            <td>
                                <select class="quantity" data-id="{{ $item['rowId'] }}">
                                    <option {{ $item['qty'] == 1 ? 'selected' : '' }}>1</option>
                                    <option {{ $item['qty'] == 2 ? 'selected' : '' }}>2</option>
                                    <option {{ $item['qty'] == 3 ? 'selected' : '' }}>3</option>
                                    <option {{ $item['qty'] == 4 ? 'selected' : '' }}>4</option>
                                    <option {{ $item['qty'] == 5 ? 'selected' : '' }}>5</option>
                                </select>
                            </td>
                            <td>INR. {{ $item['subtotal'] }}</td>
                            <td class=""></td>
                            <td>
                                <form action="{{ url('cart', [$item['rowId']]) }}" method="POST" class="side-by-side">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" class="btn btn-danger btn-sm" value="Remove">
                                </form>
                            </td>
                        </tr>

                    @endforeach
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">Subtotal</td>
                        <td>INR. {{ $subtotal }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="table-image"></td>
                        <td></td>
                        <td class="small-caps table-bg" style="text-align: right">Tax</td>
                        <td>INR. {{ $tax }}</td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr class="border-bottom">
                        <td class="table-image"></td>
                        <td style="padding: 40px;"></td>
                        <td class="small-caps table-bg" style="text-align: right">Your Total</td>
                        <td class="table-bg">INR. {{ $total }}</td>
                        <td class="column-spacer"></td>
                        <td></td>
                    </tr>

                    </tbody>
                </table>

                <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Continue Shopping</a> &nbsp;
                <a href="#" class="btn btn-success btn-lg">Proceed to Checkout</a>

                <div style="float:right">
                    <form action="{{ url('/emptyCart') }}" method="POST">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="submit" class="btn btn-danger btn-lg" value="Empty Cart">
                    </form>
                </div>

            @else

                <h3>You have no items in your shopping cart</h3>
                <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">Continue Shopping</a>

            @endif

            <div class="spacer"></div>
        </div>
    </div>

@endsection

@section('footer_scripts')
    <script>
        (function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.quantity').on('change', function () {
                var id = $(this).attr('data-id')
                $.ajax({
                    type: "PATCH",
                    url: '{{ url("/cart") }}' + '/' + id,
                    data: {
                        'quantity': this.value,
                    },
                    success: function (data) {
                        window.location.href = '{{ url('/cart') }}';
                    }
                });

            });

        })();

    </script>
@endsection
