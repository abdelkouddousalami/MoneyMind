<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-6">Add New Expense</h2>

                    <form action="{{ route('expenses.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Expense Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Amount')" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1 block w-full pl-7" required />
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_recurring" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <span class="ml-2 text-sm text-gray-600">This is a recurring expense</span>
                            </label>
                        </div>

                        <div id="recurring-options" class="hidden space-y-4">
                            <div>
                                <x-input-label for="frequency" :value="__('Frequency')" />
                                <select id="frequency" name="frequency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="monthly">Monthly</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="next_date" :value="__('Next Payment Date')" />
                                <x-text-input id="next_date" name="next_date" type="date" class="mt-1 block w-full" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="button" onclick="window.history.back()">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button class="ml-3">
                                {{ __('Add Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const recurringCheckbox = document.querySelector('input[name="is_recurring"]');
        const recurringOptions = document.getElementById('recurring-options');

        recurringCheckbox.addEventListener('change', function() {
            recurringOptions.classList.toggle('hidden', !this.checked);
        });
    </script>
    @endpush
</x-app-layout> 