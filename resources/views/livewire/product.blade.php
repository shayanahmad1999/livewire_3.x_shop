<div>
    <x-app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
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
                        <div class="flex items-center justify-end d p-4">
                            <div class="flex">
                                <div class="relative w-full">
                                    <div class="flex">
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
                                        <div class="w-2/4">
                                            <input wire:model.live.debounce.300ms="search" type="text"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                                placeholder="Search" required="">
                                        </div>
                                        <div class="w-2/4">
                                            <button x-data @click="$dispatch('open-modal', {name: 'add'})" class="px-3 float-right py-1 bg-teal-500 text-white rounded">Add</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                    <tr>
                                        @include('livewire.includes.table-sorttable-th', [
                                            'name' => 'product_name',
                                            'displayName' => 'Name',
                                        ])
                                        @include('livewire.includes.table-sorttable-th', [
                                            'name' => 'description',
                                            'displayName' => 'Description',
                                        ])
                                        @include('livewire.includes.table-sorttable-th', [
                                            'name' => 'price',
                                            'displayName' => 'Price',
                                        ])
                                        @include('livewire.includes.table-sorttable-th', [
                                            'name' => 'stock_quantity',
                                            'displayName' => 'Stock quantity',
                                        ])
                                        @include('livewire.includes.table-sorttable-th', [
                                            'name' => 'created_at',
                                            'displayName' => 'Joined',
                                        ])
                                        <th scope="col" class="px-4 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr wire:key="{{ $product->id }}" class="border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $product->product_name }}</th>
                                            <td class="px-4 py-3">{{ $product->description }}</td>
                                            <td class="px-4 py-3">{{ $product->price }}</td>
                                            <td class="px-4 py-3">{{ $product->stock_quantity }}</td>
                                            <td class="px-4 py-3">{{ $product->created_at }}</td>
                                            <td class="px-4 py-3 flex items-center justify-end">
                                                <button
                                                    onclick="confirm('Are you sure you want to delete {{ $product->product_name }} ?') || event.stopImmediatePropagation()"
                                                    wire:click="delete({{ $product->id }})"
                                                    class="px-3 py-1 bg-red-500 text-white rounded">X</button>
                                                
                                                <button x-data wire:click="edit({{$product->id}}, {name: 'add'})"
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
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>

    {{-- modal  --}}
    <x-newModal name="add" title="{{$editProduct ? 'Update' : 'Create'}} Product">
        <x-slot:body>
            <x-validation-errors class="mb-4" />
            <form wire:submit.prevent="{{ $editProduct ? 'update' : 'store' }}">
                <div>
                    <x-label for="name" value="{{ __('Name') }}" />
                    <x-input id="name" class="block mt-1 w-full" type="text" name="product_name"
                        wire:model="product_name" :value="old('product_name')" autofocus autocomplete="username" />
                </div>
                <div class="mt-4">
                    <x-label for="description" value="{{ __('Description') }}" />
                    <x-input id="description" class="block mt-1 w-full" type="text" name="description"
                        wire:model="description" :value="old('description')" autofocus autocomplete="username" />
                </div>
                <div class="mt-4">
                    <x-label for="price" value="{{ __('Price') }}" />
                    <x-input id="price" class="block mt-1 w-full" type="number" name="price"
                        wire:model="price" :value="old('price')" autofocus autocomplete="username" />
                </div>
                <div class="mt-4">
                    <x-label for="stock_quantity" value="{{ __('Stock quantity') }}" />
                    <x-input id="stock_quantity" class="block mt-1 w-full" type="number" name="stock_quantity"
                        wire:model="stock_quantity" :value="old('stock_quantity')" autofocus autocomplete="username" />
                </div>
                <x-button class="mt-4">{{$editProduct ? 'Update' : 'Create'}}</x-button>
            </form>
        </x-slot>
    </x-newModal>
    {{-- modal --}}
    

</div>
