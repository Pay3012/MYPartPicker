<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold mb-4">Your Saved Builds</h3>

            @forelse ($builds as $build)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-semibold text-gray-800">{{ $build->name }}</h4>
                            <span class="text-sm text-gray-500">{{ $build->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100 border-b">
                                    <tr>
                                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Category</th>
                                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Part</th>
                                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Qty</th>
                                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Price</th>
                                        <th class="text-left py-2 px-4 font-semibold text-gray-700">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $total = 0; @endphp
                                    @foreach ($build->parts as $part)
                                        @php
                                            $qty      = $part->pivot->quantity;
                                            $price    = $part->pivot->custom_price;
                                            $subtotal = $qty * $price;
                                            $total   += $subtotal;
                                        @endphp
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-2 px-4">{{ $part->category }}</td>
                                            <td class="py-2 px-4">{{ $part->name }}</td>
                                            <td class="py-2 px-4">{{ $qty }}</td>
                                            <td class="py-2 px-4">RM {{ number_format($price, 2) }}</td>
                                            <td class="py-2 px-4">RM {{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50 font-semibold">
                                        <td colspan="4" class="py-2 px-4 text-right">Total</td>
                                        <td class="py-2 px-4">RM {{ number_format($total, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-500">
                        You have no saved builds yet.
                        <a href="{{ route('pcbuild') }}" class="text-indigo-600 hover:underline ml-1">Start building</a>.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
