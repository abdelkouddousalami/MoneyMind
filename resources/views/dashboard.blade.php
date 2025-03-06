<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Remaining Income</h3>
                    <p class="text-3xl font-bold text-emerald-600">${{ number_format($remainingIncome, 2) }}</p>
                    <p class="text-sm text-gray-500">of ${{ number_format($totalIncome, 2) }}</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Total Expenses</h3>
                    <p class="text-3xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                    <p class="text-sm text-gray-500">This Month</p>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Savings Goal</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-emerald-600 bg-emerald-200">
                                    Progress
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-emerald-600">
                                    {{ $savingsProgress }}%
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                            <div style="width:{{$savingsProgress}}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Spending by Category</h3>
                <div class="h-64">
                    <canvas id="expenseChart"></canvas>
                </div>
            </div>

            <!-- Wishlist Progress -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Wishlist Progress</h3>
                <div class="space-y-4">
                    @foreach($wishlistItems as $item)
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-medium text-gray-900">{{ $item->name }}</h4>
                            <span class="text-sm text-gray-500">${{ number_format($item->saved, 2) }} / ${{ number_format($item->price, 2) }}</span>
                        </div>
                        <div class="relative pt-1">
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                                <div style="width:{{ ($item->saved / $item->price) * 100 }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Financial Insights</h3>
                <div class="space-y-4">
                    @foreach($aiSuggestions as $suggestion)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <p class="text-gray-600">{{ $suggestion }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('expenseChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($categories->pluck('name')) !!},
                datasets: [{
                    data: {!! json_encode($categories->pluck('amount')) !!},
                    backgroundColor: [
                        '#10B981', '#3B82F6', '#6366F1', '#EC4899', '#F59E0B'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    @endpush
</x-app-layout> 