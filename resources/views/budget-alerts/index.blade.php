<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Budget Alert Settings</h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('budget-alerts.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Global Threshold -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Global Spending Threshold</h3>
                            <div class="flex items-center gap-4">
                                <input type="range" 
                                       id="global_threshold" 
                                       name="global_threshold" 
                                       min="0" 
                                       max="100" 
                                       value="{{ $settings->global_threshold }}" 
                                       class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                <span id="global_threshold_value" class="text-sm font-medium text-gray-900">
                                    {{ $settings->global_threshold }}%
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">
                                Get alerted when your total spending exceeds this percentage of your income
                            </p>
                        </div>

                        <!-- Category Limits -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Category Spending Limits</h3>
                            @foreach($categories as $category)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $category->name }}
                                </label>
                                <div class="flex items-center gap-4">
                                    <input type="range" 
                                           id="category_{{ $category->id }}" 
                                           name="category_limits[{{ $category->id }}]" 
                                           min="0" 
                                           max="100" 
                                           value="{{ $categoryLimits[$category->id] ?? 0 }}" 
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    <span id="category_{{ $category->id }}_value" class="text-sm font-medium text-gray-900">
                                        {{ $categoryLimits[$category->id] ?? 0 }}%
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Notification Settings -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Settings</h3>
                            <div class="space-y-4">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="email_notifications" 
                                           class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                           {{ $settings->email_notifications ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Email Notifications</span>
                                </label>

                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="push_notifications" 
                                           class="rounded border-gray-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                           {{ $settings->push_notifications ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Push Notifications</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Save Settings') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update range input values
        document.querySelectorAll('input[type="range"]').forEach(range => {
            const valueDisplay = document.getElementById(`${range.id}_value`);
            range.addEventListener('input', (e) => {
                valueDisplay.textContent = `${e.target.value}%`;
            });
        });
    </script>
    @endpush
</x-app-layout> 