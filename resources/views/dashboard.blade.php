<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Your Saved Builds</h3>
                <a href="{{ route('pcbuild') }}"
                   class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 text-sm font-medium">
                    + Create Build
                </a>
            </div>

            @if(session('success'))
                <p class="mb-4 text-green-600 font-medium">{{ session('success') }}</p>
            @endif

            @forelse ($builds as $build)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-base font-semibold text-gray-800">{{ $build->name }}</h4>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-500">{{ $build->created_at->format('d M Y') }}</span>
                                <button
                                    onclick="openRenameModal({{ $build->id }}, '{{ addslashes($build->name) }}')"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    Rename
                                </button>
                                <form action="{{ route('pcbuild.destroy', $build) }}" method="POST"
                                      onsubmit="return confirm('Delete this build?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
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

    <!-- Rename Modal -->
    <div id="rename-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Rename Build</h3>
            <form id="rename-form" method="POST">
                @csrf
                @method('PATCH')
                <input
                    type="text"
                    id="rename-input"
                    name="name"
                    required
                    maxlength="100"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
                <div class="flex justify-end gap-3">
                    <button type="button"
                        onclick="document.getElementById('rename-modal').classList.add('hidden')"
                        class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openRenameModal(buildId, currentName) {
            const base = "{{ url('/pcbuild') }}";
            document.getElementById('rename-form').action = base + '/' + buildId;
            document.getElementById('rename-input').value = currentName;
            document.getElementById('rename-modal').classList.remove('hidden');
        }
    </script>
</x-app-layout>
