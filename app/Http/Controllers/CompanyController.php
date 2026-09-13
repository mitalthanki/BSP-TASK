<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $companies = $request->user()->companies()
            ->with(['country', 'state', 'city', 'services', 'branches'])
            ->latest()
            ->paginate(15);

        return view('companies.index', compact('companies'));
    }

    public function create(): View
    {
        return view('companies.create', [
            'countries' => Country::query()->with('states.cities')->orderBy('name')->get(),
            'services' => Service::query()->orderBy('name')->get(),
            'branches' => Branch::query()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['logo', 'services', 'branches']);

        if ($request->hasFile('logo')) {
            $data['logo'] = Storage::disk('public')->putFile('company-logos', $request->file('logo'), 'public');
        }

        $company = $request->user()->companies()->create($data);
        $company->services()->sync($request->validated('services', []));
        $company->branches()->sync($request->validated('branches', []));

        return to_route('companies.index')->with('success', 'Company created successfully.');
    }

    public function edit(Request $request, string $company): View
    {
        $company = $request->user()->companies()->findOrFail($company);

        return view('companies.edit', [
            'company' => $company->load('services', 'branches'),
            'countries' => Country::query()->with('states.cities')->orderBy('name')->get(),
            'services' => Service::query()->orderBy('name')->get(),
            'branches' => Branch::query()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateCompanyRequest $request, string $company): RedirectResponse
    {
        $company = $request->user()->companies()->findOrFail($company);
        $data = $request->safe()->except(['logo', 'services', 'branches']);

        if ($request->hasFile('logo')) {
            $oldLogo = $company->logo;
            $data['logo'] = Storage::disk('public')->putFile('company-logos', $request->file('logo'), 'public');

            if ($oldLogo !== null) {
                Storage::disk('public')->delete($oldLogo);
            }
        }

        $company->update($data);
        $company->services()->sync($request->validated('services', []));
        $company->branches()->sync($request->validated('branches', []));

        return to_route('companies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy(Request $request, string $company): RedirectResponse
    {
        $company = $request->user()->companies()->findOrFail($company);

        if ($company->logo !== null) {
            Storage::disk('public')->delete($company->logo);
        }

        $company->delete();

        return to_route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
