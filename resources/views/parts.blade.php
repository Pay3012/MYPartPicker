<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- 🔍 Search Form -->
                    <form method="GET" action="{{ route('parts') }}" class="mb-6">
                        <div class="flex items-center">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}" 
                                placeholder="Search by part name or category..." 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            />
                            <button 
                                type="submit" 
                                class="ml-3 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>
                        </div>
                    </form>

                    <!-- 🧾 Parts Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100 border-b">
                                <tr>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">ID</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Category</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Name</th>
                                    <th class="text-left py-2 px-4 font-semibold text-gray-700">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($parts as $part)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4">{{ $part->id }}</td>
                                        <td class="py-2 px-4">{{ $part->category }}</td>
                                        <td class="py-2 px-4">{{ $part->name }}</td>
                                        <td class="py-2 px-4">{{ $part->price }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">
                                            No parts found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- 📄 Pagination -->
                    <div>
                        {{ $parts->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
