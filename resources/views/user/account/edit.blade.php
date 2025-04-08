@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container vh-100 d-flex align-items-center">
            <div class="col-md-8">
                
                    <h4 class="mb-0">Edit Bank Account</h4>
                <div class="card-body p-4">
                    <form action="{{ route('accounts.update', $account->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Account Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Account Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $account->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bank Name -->
                        <div class="mb-3">
                            <label for="bank_name" class="form-label">Bank Name</label>
                            <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name"
                                name="bank_name" value="{{ old('bank_name', $account->bank_name) }}" required>
                            @error('bank_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Account Type -->
                        <div class="mb-3">
                            <label for="account_type" class="form-label">Account Type</label>
                            <select class="form-select @error('account_type') is-invalid @enderror" id="account_type"
                                name="account_type" required>
                                @foreach(App\Enums\AccountType::cases() as $type)
                                    <option value="{{ $type->value }}" {{ old('account_type', $account->account_type) == $type->value ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Initial Balance -->
                        <div class="mb-3">
                            <label for="initial_balance" class="form-label">Initial Balance</label>
                            <input type="number" step="0.01"
                                class="form-control @error('initial_balance') is-invalid @enderror" id="initial_balance"
                                name="initial_balance" value="{{ old('initial_balance', $account->initial_balance) }}"
                                required>
                            @error('initial_balance')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection