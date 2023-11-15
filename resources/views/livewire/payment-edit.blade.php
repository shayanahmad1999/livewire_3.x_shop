<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-5 py-5 float-right">
                        <a wire:navigate.hover href="{{route('payment')}}" class="px-3 float-right py-1 bg-teal-500 text-white rounded">View</a>
                    </div>
                    <div class="flex">
                        <div class="w-full mb-5 ml-5 mt-5 py-5 px-5">
                            @if (session('success'))
                                <div id="alert-3"
                                    class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                                    role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                                    </svg>
                                    <span class="sr-only">Info</span>
                                    <div class="ms-3 text-sm font-medium">
                                        {{ session('success') }}
                                    </div>
                                    <button type="button"
                                        class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                        data-dismiss-target="#alert-3" aria-label="Close">
                                        <span class="sr-only">Close</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                    </button>
                                </div>
                            @endif
                            <x-validation-errors class="mb-4" />
                            <form wire:submit.prevent="update">
                                <div>
                                    <x-label value="{{__('Order')}}" />
                                    <select wire:model='order_id' wire:change='calculateSubtotal' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select an Order</option>
                                        @foreach ($orders as $order)
                                            <option value="{{$order->id}}">{{$order->customer->first_name}} {{$order->customer->last_name}} ({{$order->total_amount}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="payment_date" value="{{ __('Payment date') }}" />
                                    <x-input id="payment_date" class="block mt-1 w-full" type="datetime-local" name="payment_date"
                                        wire:model="payment_date" :value="old('payment_date')" autofocus autocomplete="username" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="amount" value="{{ __('Amount') }}" />
                                    <x-input id="amount" class="block mt-1 w-full" type="number" name="amount"
                                        wire:model="amount" readonly :value="old('amount')" autofocus autocomplete="username" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="payment_method" value="{{ __('Payment method') }}" />
                                    <x-input id="payment_method" class="block mt-1 w-full" type="text" name="payment_method"
                                        wire:model="payment_method" :value="old('payment_method')" autofocus autocomplete="username" />
                                </div>
                                <x-button class="mt-4">Update</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

</div>
