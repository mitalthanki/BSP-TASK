<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Company</h2>
            <a href="{{ route('companies.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">Back to companies</a>
        </div>
    </x-slot>

    @php
        $selectedServices = old('services', $company->services->modelKeys());
        $selectedBranches = old('branches', $company->branches->modelKeys());
    @endphp

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('companies.update', $company) }}" enctype="multipart/form-data" class="bg-white shadow-sm rounded-lg p-6 space-y-6" x-data="{
                states: [],
                cities: [],
                countryId: @js((string) old('country_id', $company->country_id)),
                stateId: @js((string) old('state_id', $company->state_id)),
                cityId: @js((string) old('city_id', $company->city_id)),
                async loadStates(reset = true) {
                    if (reset) { this.stateId = ''; this.cityId = ''; }
                    this.states = []; this.cities = [];
                    if (! this.countryId) return;
                    const response = await fetch('/states/' + this.countryId, { headers: { Accept: 'application/json' } });
                    this.states = await response.json();
                },
                async loadCities(reset = true) {
                    if (reset) this.cityId = '';
                    this.cities = [];
                    if (! this.stateId) return;
                    const response = await fetch('/cities/' + this.stateId, { headers: { Accept: 'application/json' } });
                    this.cities = await response.json();
                },
                async init() { await this.loadStates(false); await this.loadCities(false); }
            }" x-init="init()">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <x-input-label for="logo" value="Company Logo" />
                        @if ($company->logo)
                            <img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->company_name }} logo" class="mt-2 h-16 w-16 rounded-md object-cover" />
                        @endif
                        <input id="logo" name="logo" type="file" accept="image/*" class="mt-2 block w-full text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100" />
                        <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="company_name" value="Company Name" />
                        <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $company->company_name)" required autofocus />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $company->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="mobile" value="Mobile" />
                        <x-text-input id="mobile" name="mobile" type="tel" class="mt-1 block w-full" :value="old('mobile', $company->mobile)" required />
                        <x-input-error :messages="$errors->get('mobile')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="country_id" value="Country" />
                        <select id="country_id" name="country_id" x-model="countryId" @change="loadStates()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Select country</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="state_id" value="State" />
                        <select id="state_id" name="state_id" x-model="stateId" @change="loadCities()" :disabled="! countryId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100" required>
                            <option value="">Select state</option>
                            <template x-for="state in states" :key="state.id"><option :value="state.id" x-text="state.name"></option></template>
                        </select>
                        <x-input-error :messages="$errors->get('state_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="city_id" value="City" />
                        <select id="city_id" name="city_id" x-model="cityId" :disabled="! stateId" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100" required>
                            <option value="">Select city</option>
                            <template x-for="city in cities" :key="city.id"><option :value="city.id" x-text="city.name"></option></template>
                        </select>
                        <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="services" value="Services" />
                    <select id="services" name="services[]" multiple class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}" @selected(in_array($service->id, $selectedServices))>{{ $service->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple services.</p>
                    <x-input-error :messages="$errors->get('services')" class="mt-2" />
                    <x-input-error :messages="$errors->get('services.*')" class="mt-2" />
                </div>

                <fieldset>
                    <legend class="text-sm font-medium text-gray-700">Branches</legend>
                    <div class="mt-2 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ($branches as $branch)
                            <label class="flex items-center gap-2 rounded-md border border-gray-200 p-3 text-sm text-gray-700">
                                <input type="checkbox" name="branches[]" value="{{ $branch->id }}" @checked(in_array($branch->id, $selectedBranches)) class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                {{ $branch->name }}
                            </label>
                        @endforeach
                    </div>
                    <x-input-error :messages="$errors->get('branches')" class="mt-2" />
                    <x-input-error :messages="$errors->get('branches.*')" class="mt-2" />
                </fieldset>

                <div class="flex justify-end gap-3 border-t pt-6">
                    <a href="{{ route('companies.index') }}" class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 hover:bg-gray-50">Cancel</a>
                    <x-primary-button>Update Company</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
