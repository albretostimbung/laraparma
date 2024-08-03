<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Manage Categories') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Edit a category and manage it.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('admin.categories.update', $category) }}"
                            class="mt-6 space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                    :value="old('name', $category->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="icon" :value="__('Icon')" />
                                <img src="{{ asset('storage/' . $category->icon) }}" alt="{{ $category->name }}"
                                    class="w-8 h-8 object-cover">
                                <x-text-input id="icon" name="icon" type="file" class="mt-1 block w-full" />
                                <x-input-error class="mt-2" :messages="$errors->get('icon')" />
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
