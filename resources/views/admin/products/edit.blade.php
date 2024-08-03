<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Manage Products') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Edit a product and manage it.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('admin.products.update', $product) }}" class="mt-6 space-y-6"
                            enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <!-- Name Input -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $product->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Photo Input -->
                            <div>
                                <x-input-label for="photo" :value="__('Photo')" />
                                <img src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->name }}"
                                    class="w-16 h-16 object-cover">
                                <x-text-input id="photo" name="photo" type="file" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('photo')" />
                            </div>

                            <!-- Price Input -->
                            <div>
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" :value="old('price', $product->price)"
                                    required />
                                <x-input-error class="mt-2" :messages="$errors->get('price')" />
                            </div>

                            <!-- About Input -->
                            <div>
                                <x-input-label for="about" :value="__('About')" />
                                <textarea id="about" name="about"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    rows="4" required>{{ old('about', $product->about) }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('about')" />
                            </div>

                            <!-- Category Input -->
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
