<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
            <a href="{{ route('companies.create') }}" class="inline-flex items-center justify-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700">Add Company</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700" role="status">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                @if ($companies->isEmpty())
                    <div class="px-6 py-16 text-center">
                        <p class="text-gray-600">No companies have been created yet.</p>
                        <a href="{{ route('companies.create') }}" class="mt-4 inline-block text-sm font-medium text-indigo-600 hover:text-indigo-800">Create your first company</a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Company</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Contact</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Location</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Services</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($companies as $company)
                                    <tr>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($company->logo)
                                                    <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->company_name }} logo" class="h-10 w-10 rounded-md object-cover" />
                                                @else
                                                    <div class="flex h-10 w-10 items-center justify-center rounded-md bg-indigo-50 text-sm font-semibold text-indigo-700">{{ str($company->company_name)->substr(0, 1)->upper() }}</div>
                                                @endif
                                                <span class="font-medium text-gray-900">{{ $company->company_name }}</span>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                            <div>{{ $company->email }}</div>
                                            <div>{{ $company->mobile }}</div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $company->city->name }}, {{ $company->state->name }}, {{ $company->country->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $company->services->pluck('name')->join(', ') ?: '—' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <a href="{{ route('companies.edit', $company) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form method="POST" action="{{ route('companies.destroy', $company) }}" class="ml-3 inline" onsubmit="return confirm('Delete this company?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-gray-200 px-6 py-4">
                        {{ $companies->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
