<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mt-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">
                            {{ __('Details') }}</h3>
                        <!-- Order Details -->
                        <div class="mt-6 space-y-6">
                            <div class="bg-gray-50 p-4 rounded-md">
                                <h4 class="text-md font-medium text-gray-700">{{ __('Order Information') }}</h4>
                                <div class="mt-2">
                                    <p><strong>{{ __('Order ID:') }}</strong> {{ $productTransaction->id }}</p>
                                    <p><strong>{{ __('Customer Name:') }}</strong> {{ $productTransaction->user->name }}
                                    </p>
                                    <p><strong>{{ __('Total Amount:') }}</strong> Rp
                                        {{ number_format($productTransaction->total_amount, 0, ',', '.') }}</p>
                                    <p><strong>{{ __('Date:') }}</strong>
                                        {{ $productTransaction->created_at->format('d F Y') }}</p>
                                    <p><strong>{{ __('Status:') }}</strong>
                                        @if ($productTransaction->is_paid)
                                            <span
                                                class="inline-flex items-center px-3.5 py-1.5 rounded-full text-md font-medium bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-md font-medium bg-red-100 text-red-800">
                                                Pending
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="mt-6">
                                <h4 class="text-md font-medium text-gray-700">{{ __('Order Items') }}</h4>
                                <div class="mt-2">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Product
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Category
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Price
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($productTransaction->transaction_details as $item)
                                                <tr>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                        {{ $item->product->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $item->product->category->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <!-- Delivery Information -->
                            <div class="mt-6 bg-gray-50 p-4 rounded-md">
                                <h4 class="text-md font-medium text-gray-700">{{ __('Delivery Information') }}</h4>
                                <div class="mt-2">
                                    <p><strong>{{ __('Address:') }}</strong>
                                        {{ $productTransaction->address }}</p>
                                    <p><strong>{{ __('City:') }}</strong>
                                        {{ $productTransaction->city }}</p>
                                    <p><strong>{{ __('Post Code:') }}</strong>
                                        {{ $productTransaction->post_code }}</p>
                                    <p><strong>{{ __('Phone Number:') }}</strong>
                                        {{ $productTransaction->phone_number }}</p>
                                    <p><strong>{{ __('Notes:') }}</strong>
                                    <div class="text-sm">{{ $productTransaction->notes }}</div>
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <!-- Proof of Payment -->
                            @if ($productTransaction->proof)
                                <div class="mt-6 bg-gray-50 p-4 rounded-md">
                                    <h4 class="text-md font-medium text-gray-700">{{ __('Proof of Payment') }}</h4>
                                    <div class="mt-2">
                                        <p><strong>{{ __('Receipt:') }}</strong></p>
                                        <a href="{{ asset('storage/' . $productTransaction->proof) }}" target="_blank"
                                            class="text-blue-600 hover:text-blue-900">
                                            {{ __('View Proof of Payment') }}
                                        </a>
                                    </div>
                                </div>

                                <hr>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-6 flex items-center gap-4">
                                @role('owner')
                                    @if ($productTransaction->is_paid)
                                        <a href="#" class="text-blue-600 hover:text-blue-900">
                                            {{ __('Contact Admin') }}
                                        </a>
                                    @else
                                        <form
                                            action="{{ route('admin.product-transactions.update', $productTransaction) }}"
                                            method="POST" class="inline ml-4">
                                            @csrf
                                            @method('put')
                                            <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                {{ __('Approve Order') }}
                                            </button>
                                        </form>
                                    @endif
                                @endrole

                                @role('buyer')
                                    <a href="#" class="text-blue-600 hover:text-blue-900">
                                        {{ __('Contact Admin') }}
                                    </a>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
