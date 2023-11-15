<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex">
                        <div class="w-2/4 mb-5 ml-5 mt-5 py-5 px-5">
                            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                                <div class="flex items-center justify-between d p-4">
                                    <div class="flex">
                                        <div class="relative w-full">
                                            <div
                                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                    fill="currentColor" viewbox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <input wire:model.live.debounce.300ms="search" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                                placeholder="Search" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead>
                                            <tr>
                                                @include('livewire.includes.table-sorttable-th', [
                                                   'name' => 'id',
                                                   'displayName' => 'Name' 
                                                ])
                                                @include('livewire.includes.table-sorttable-th', [
                                                    'name' => 'order_date',
                                                    'displayName' => 'Order date' 
                                                 ])
                                                  @include('livewire.includes.table-sorttable-th', [
                                                    'name' => 'total_amount',
                                                    'displayName' => 'Total amount' 
                                                 ])
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{$order->customer->first_name}} {{$order->customer->last_name}}</td>
                                                    <td>{{$order->order_date}}</td>
                                                    <td>{{$order->total_amount}}</td>
                                                    <td>
                                                        <button onclick="confirm('Are you sure you want to delete ?') || event.stopImmediatePropagation()"
                                                            wire:click="delete({{$order->id}})"
                                                            class="px-3 py-1 bg-red-500 text-white rounded">
                                                            X
                                                        </button>
                                                        <button wire:click="edit({{ $order->id }})"
                                                            class="px-3 py-1 bg-indigo-500 text-white rounded">
                                                            edit
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="py-4 px-3">
                                    <div class="flex ">
                                        <div class="flex space-x-4 items-center mb-3">
                                            <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                                            <select wire:model.live='perPage'
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                                <option value="5">5</option>
                                                <option value="7">7</option>
                                                <option value="10">10</option>
                                                <option value="20">20</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{ $orders->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="w-2/4 mb-5 ml-5 mt-5 py-5 px-5">
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
                            <form wire:submit.prevent="{{$editOrder ? 'update' : 'store'}}">
                                <div>
                                    <x-label value="{{__('Customer')}}" />
                                    <select wire:model='customer_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select a Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->first_name}} {{$customer->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="order_date" value="{{ __('Order date') }}" />
                                    <x-input id="order_date" class="block mt-1 w-full" type="datetime-local" name="order_date"
                                        wire:model="order_date" :value="old('order_date')" autofocus autocomplete="username" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="total_amount" value="{{ __('Total amount') }}" />
                                    <x-input id="total_amount" class="block mt-1 w-full" type="number" name="total_amount"
                                        wire:model="total_amount" :value="old('total_amount')" autofocus autocomplete="username" />
                                </div>
                                <x-button class="mt-4">{{$editOrder ? 'Update' : 'Create'}}</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

</div>
