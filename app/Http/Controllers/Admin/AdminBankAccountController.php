<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class AdminBankAccountController extends BaseController
{
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(15);
        return view('admin.payment-settings.bank-accounts.index', compact('bankAccounts'));
    }

    public function create()
    {
        return view('admin.payment-settings.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        BankAccount::create($validated);

        return $this->successRedirect('admin.bank-accounts.index', 'Rekening bank berhasil ditambahkan!');
    }

    public function edit(BankAccount $bankAccount)
    {
        return view('admin.payment-settings.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $bankAccount->update($validated);

        return $this->successRedirect('admin.bank-accounts.index', 'Rekening bank berhasil diupdate!');
    }

    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();
        return $this->successRedirect('admin.bank-accounts.index', 'Rekening bank berhasil dihapus!');
    }
}