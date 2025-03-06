<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Savings Goals</h2>
                <button @click="$dispatch('open-modal', 'add-goal')" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-md">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add New Goal
                </button>
            </div>

            <!-- Goals Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($savingsGoals as $goal)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $goal->name }}</h3>
                            <div class="flex items-center space-x-2">
                                <button @click="$dispatch('open-modal', 'edit-goal-{{ $goal->id }}')" class="text-gray-400 hover:text-gray-500">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-500">Progress</span>
                                <span class="text-gray-900 font-medium">
                                    ${{ number_format($goal->current_amount, 2) }} / ${{ number_format($goal->target_amount, 2) }}
                                </span>
                            </div>
                            <div class="relative pt-1">
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-emerald-200">
                                    <div style="width:{{ ($goal->current_amount / $goal->target_amount) * 100 }}%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Target Date: {{ $goal->target_date->format('M d, Y') }}</span>
                            <span>{{ $goal->daysRemaining }} days left</span>
                        </div>

                        <div class="mt-4">
                            <button @click="$dispatch('open-modal', 'add-contribution-{{ $goal->id }}')" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-emerald-600 text-sm font-medium rounded-md text-emerald-600 hover:bg-emerald-50">
                                Add Contribution
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add Goal Modal -->
    <x-modal name="add-goal">
        <form action="{{ route('savings-goals.store') }}" method="POST" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 mb-4">Create New Savings Goal</h2>
            
            <div class="space-y-4">
                <div>
                    <x-input-label for="name" :value="__('Goal Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="target_amount" :value="__('Target Amount')" />
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <x-text-input id="target_amount" name="target_amount" type="number" step="0.01" class="mt-1 block w-full pl-7" required />
                    </div>
                </div>

                <div>
                    <x-input-label for="target_date" :value="__('Target Date')" />
                    <x-text-input id="target_date" name="target_date" type="date" class="mt-1 block w-full" required />
                </div>
            </div>

            <div class="mt-6 flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                <x-primary-button>Create Goal</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout> 