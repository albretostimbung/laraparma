@extends('layouts.front', ['title' => 'Register'])

@section('content')
    <div class="flex flex-col items-center px-6 py-10 min-h-dvh">
        <img src="{{ asset('assets/svgs/logo.svg') }}" class="mb-[53px]" alt="">
        <form method="POST" action="{{ route('register') }}"
            class="mx-auto max-w-[345px] w-full p-6 bg-white rounded-3xl mt-auto" id="deliveryForm">
            @csrf
            <div class="flex flex-col gap-5">
                <p class="text-[22px] font-bold">
                    New Account
                </p>
                <!-- Full Name -->
                <div class="flex flex-col gap-2.5">
                    <label for="name" class="text-base font-semibold">Full Name</label>
                    <input type="text" name="name" id="name__"
                        style="background-image: url('{{ asset('assets/svgs/ic-profile.svg') }}')" class="form-input"
                        placeholder="Write your full name">
                </div>
                <!-- Email Address -->
                <div class="flex flex-col gap-2.5">
                    <label for="email" class="text-base font-semibold">Email Address</label>
                    <input type="email" name="email" id="email__"
                        style="background-image: url('{{ asset('assets/svgs/ic-email.svg') }}')" class="form-input"
                        placeholder="Your email address">
                </div>
                <!-- Password -->
                <div class="flex flex-col gap-2.5">
                    <label for="password" class="text-base font-semibold">Password</label>
                    <input type="password" name="password" id="password__"
                        style="background-image: url('{{ asset('assets/svgs/ic-lock.svg') }}')" class="form-input"
                        placeholder="Protect your password">
                </div>
                <!-- Confirm Password -->
                <div class="flex flex-col gap-2.5">
                    <label for="password" class="text-base font-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="confirm-password__"
                        style="background-image: url('{{ asset('assets/svgs/ic-lock.svg') }}')" class="form-input"
                        placeholder="Protect your password">
                </div>
                <button type="submit"
                    class="inline-flex text-white font-bold text-base bg-primary rounded-full whitespace-nowrap px-[30px] py-3 justify-center items-center">
                    Create My Account
                </button>
            </div>
        </form>
        <a href="{{ route('login') }}" class="font-semibold text-base mt-[30px] underline">
            Sign In to My Account
        </a>
    </div>
@endsection
