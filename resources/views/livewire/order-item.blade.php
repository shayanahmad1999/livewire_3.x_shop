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
                                                   'name' => 'order_id',
                                                   'displayName' => 'Order' 
                                                ])
                                                 @include('livewire.includes.table-sorttable-th', [
                                                    'name' => 'product_id',
                                                    'displayName' => 'Product' 
                                                 ])
                                                @include('livewire.includes.table-sorttable-th', [
                                                    'name' => 'quantity',
                                                    'displayName' => 'Quantity' 
                                                 ])
                                                  @include('livewire.includes.table-sorttable-th', [
                                                    'name' => 'subtotal',
                                                    'displayName' => 'Sub total' 
                                                 ])
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orderItems as $orderItem)
                                                <tr wire:key="{{ $orderItem->id }}" class="border-b dark:border-gray-700">
                                                    <th scope="row"
                                                    class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{$orderItem->order->customer->first_name}} {{$orderItem->order->customer->last_name}} ({{$orderItem->order->total_amount}})
                                                </th>
                                                    <td class="px-4 py-3">{{$orderItem->product->product_name}}</td>
                                                    <td class="px-4 py-3">{{$orderItem->quantity}}</td>
                                                    <td class="px-4 py-3">{{$orderItem->subtotal}}</td>
                                                    <td class="px-4 py-3 flex items-center justify-end">
                                                        <button onclick="confirm('Are you sure you want to delete ?') || event.stopImmediatePropagation()"
                                                            wire:click="delete({{$orderItem->id}})"
                                                            class="px-3 py-1 bg-red-500 text-white rounded">
                                                            X
                                                        </button>
                                                        <button wire:click="edit({{ $orderItem->id }})"
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
                                    {{ $orderItems->links() }}
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
                            <form wire:submit.prevent="{{$editOrderItem ? 'update' : 'store'}}">
                                <div>
                                    <x-label value="{{__('Order')}}" />
                                    <select wire:model='order_id' wire:change='calculateSubtotal' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select an Order</option>
                                        @foreach ($orders as $order)
                                            <option value="{{$order->id}}">{{$order->customer->first_name}} {{$order->customer->last_name}} ({{$order->total_amount}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-label value="{{__('Product')}}" />
                                    <select wire:model='product_id' class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option value="">Select a Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <x-label for="quantity" value="{{ __('Quantity') }}" />
                                    <x-input id="quantity" class="block mt-1 w-full" type="number" name="quantity"
                                        wire:model="quantity" wire:change="calculateSubtotal" :value="old('quantity')" autofocus autocomplete="username" />
                                </div>
                                <div class="mt-4">
                                    <x-label for="subtotal" value="{{ __('Sub total') }}" />
                                    <x-input id="subtotal" class="block mt-1 w-full" type="number" name="subtotal"
                                        wire:model="subtotal" :value="old('subtotal')" autofocus autocomplete="username" readonly />
                                </div>
                                <x-button class="mt-4">{{$editOrderItem ? 'Update' : 'Create'}}</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

</div>
