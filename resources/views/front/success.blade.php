@extends('layouts.front', ['title' => 'Success Checkout'])

@section('content')
    <div class="h-dvh flex flex-col justify-center items-center gap-[33px]">
        <img src="{{ asset('assets/svgs/nekodicine.svg') }}" alt="">
        <div class="flex flex-col gap-2.5 items-center">
            <p class="font-bold text-[22px] text-center">
                Yeay! Order Finished
            </p>
            <p class="text-base text-center">
                We’ve received your order and then <br>
                our staff will check them now
            </p>
        </div>
        <a href="{{ route('product-transactions.index') }}"
            class="inline-flex w-max text-white font-bold text-base bg-primary rounded-full px-[30px] py-3 justify-center items-center whitespace-nowrap">
            My Orders
        </a>
    </div>
@endsection
