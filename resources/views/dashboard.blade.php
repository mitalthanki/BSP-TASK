<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 md:grid-cols-2">
                <section class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Welcome back</p>
                    <h3 class="mt-1 text-2xl font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                    <p class="mt-3 text-sm text-gray-600">Manage your company information, services, branches, and locations from one place.</p>
                    <a href="{{ route('companies.index') }}" class="mt-5 inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">View Companies</a>
                </section>

                <section class="rounded-lg bg-white p-6 shadow-sm">
                    <p class="text-sm font-medium text-gray-500">Your Companies</p>
                    <p class="mt-2 text-4xl font-semibold text-gray-900">{{ $companyCount }}</p>
                    <p class="mt-3 text-sm text-gray-600">Create and maintain your company records.</p>
                    <a href="{{ route('companies.create') }}" class="mt-5 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">Add a company</a>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
