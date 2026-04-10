<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Build') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- 🧾 Current Build Table -->
                    <h3 class="text-lg font-semibold mb-4 mt-8">Your Current Build</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="text-left py-2 px-4">Category</th>
                                    <th class="text-left py-2 px-4">Part Name</th>
                                    <th class="text-left py-2 px-4">Amount</th>
                                    <th class="text-left py-2 px-4">Price</th>
                                    <th class="text-left py-2 px-4">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($buildParts ?? [] as $part)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $part->category }}</td>
                                        <td class="py-2 px-4">{{ $part->name }}</td>
                                        <td class="py-2 px-4">
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('pcbuild.decrement') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="part_id" value="{{ $part->id }}">
                                                    <button class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 font-bold">−</button>
                                                </form>
                                                <span>{{ $part->amount }}</span>
                                                <form action="{{ route('pcbuild.add') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="part_id" value="{{ $part->id }}">
                                                    <button class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded hover:bg-gray-300 font-bold">+</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="py-2 px-4">
                                            RM {{ number_format($part->price * $part->amount, 2) }}
                                        </td>
                                        <td class="py-2 px-4">
                                            <form action="{{ route('pcbuild.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="part_id" value="{{ $part->id }}">
                                                <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            No parts added yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- 💰 Total + Save -->
                    <div class="mt-6 flex items-center justify-between">
                        <div>
                            @if (session('success'))
                                <p class="text-green-600 font-medium">{{ session('success') }}</p>
                            @elseif (session('error'))
                                <p class="text-red-600 font-medium">{{ session('error') }}</p>
                            @elseif (!auth()->check() && count($buildParts) > 0)
                                <p class="text-gray-600">
                                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">Log in</a>
                                    or
                                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">Register</a>
                                    to save your build.
                                </p>
                            @endif
                        </div>

                        <div class="flex items-center gap-4">
                            <span class="font-semibold text-lg">Total: RM {{ number_format($totalPrice ?? 0, 2) }}</span>
                            @auth
                                <button onclick="document.getElementById('save-build-modal').classList.remove('hidden')"
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-medium">
                                    Save Build
                                </button>
                            @endauth
                        </div>
                    </div>

                    <!-- 🔍 Search Parts -->
                    <form method="GET" action="{{ route('pcbuild') }}" class="mb-6">
                        <div class="flex items-center">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search parts to add..." 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <button 
                                type="submit" 
                                class="ml-3 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- 🔍 Search Results -->
                    @if(isset($parts))
                    <div class="overflow-x-auto mb-10">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="text-left py-2 px-4">Category</th>
                                    <th class="text-left py-2 px-4">Part Name</th>
                                    <th class="text-left py-2 px-4">Price</th>
                                    <th class="text-left py-2 px-4">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($parts as $part)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $part->category }}</td>
                                        <td class="py-2 px-4">{{ $part->name }}</td>
                                        <td class="py-2 px-4">RM {{ number_format($part->price, 2) }}</td>
                                        <td class="py-2 px-4">
                                            <form action="{{ route('pcbuild.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="part_id" value="{{ $part->id }}">
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                    Add
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-gray-500">
                                            No parts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{ $parts->links() ?? '' }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Save Build Modal -->
    <div id="save-build-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold mb-4">Name Your Build</h3>
            <form action="{{ route('pcbuild.save') }}" method="POST">
                @csrf
                <input
                    type="text"
                    name="build_name"
                    placeholder="e.g. Gaming Rig 2024"
                    required
                    maxlength="100"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                />
                <div class="flex justify-end gap-3">
                    <button type="button"
                        onclick="document.getElementById('save-build-modal').classList.add('hidden')"
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
</x-app-layout>
