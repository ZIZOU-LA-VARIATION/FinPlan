@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-5">
            <div class="aligne">
                <div>
                    <img src="{{asset('assets/img/account.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Bank Accounts</span>
                </h2>
            </div>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="transaction-header mb-3">

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accountModal">
                    <i class="fas fa-plus"></i> Add Account
                </button>

                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search account...">

            </div>


            <!-- Tableau des comptes -->
            <div class="card-body px-0 pt-0 pb-2">
                @if($accounts->isEmpty())
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle-fill me-2"></i> No account found.
                </div>
            @else
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">

                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Bank Name</th>
                                <th>Type</th>
                                <th>Initial Balance</th>
                                <th>Current Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody id="Table">
                            @foreach($accounts as $account)
                                <tr>
                                    <td>{{ $account->name }}</td>
                                    <td>{{ $account->bank_name }}</td>
                                    <td><span class="badge bg-primary">{{ $account->account_type }}</span></td>
                                    <td class="text-success fw-bold">{{ $account->initial_balance }}</td>
                                    <td class="text-danger fw-bold">-4,500 FCFA</td>
                                    <td>
                                        <!-- Bouton dans la colonne Actions -->
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editAccountModal{{ $account->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>


                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#deleteAccountModal{{ $account->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    

                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showAccountModal{{ $account->id }}">
                                            <i class="bi bi-eye-fill me-1"></i>
                                        </button>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @endif
                <!-- Pagination -->
                <div class="d-flex justify-content-center align-items-center mb-4">
                    <!-- Bouton précédent placé avant la pagination -->
                    <button class="btn btn-primary me-3" id="prevButton" disabled>Previous</button>

                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination">
                            <!-- Pagination dynamique ici -->
                        </ul>
                    </nav>

                    <!-- Bouton suivant -->
                    <button class="btn btn-primary ms-3" id="nextButton" disabled>Next</button>
                </div>


            </div>
        </div>


        <!-- Modal pour l'ajout d'un compte bancaire -->
        <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('accounts.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="accountModalLabel">Add Bank Account</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Account Name -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required placeholder="Enter account name">
                                <label for="name">Account Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Bank Name -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                    id="bank_name" name="bank_name" value="{{ old('bank_name') }}" required
                                    placeholder="Enter bank name">
                                <label for="bank_name">Bank Name</label>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Account Type -->
                            <div class="form-floating mb-3">
                                <select class="form-select @error('account_type') is-invalid @enderror" id="account_type"
                                    name="account_type" required>
                                    @foreach($accountTypes as $type)
                                        <option value="{{ $type->value }}" {{ old('account_type') == $type->value ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="account_type">Account Type</label>
                                @error('account_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Initial Balance -->
                            <div class="form-floating mb-3">
                                <input type="number" step="0.01"
                                    class="form-control @error('initial_balance') is-invalid @enderror" id="initial_balance"
                                    name="initial_balance" value="{{ old('initial_balance') }}" required
                                    placeholder="Enter initial balance">
                                <label for="initial_balance">Initial Balance</label>
                                @error('initial_balance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Save Account</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Delete Bank Account Modal -->
        @foreach ($accounts as $account)
            <div class="modal fade" id="deleteAccountModal{{ $account->id }}" tabindex="-1"
                aria-labelledby="deleteAccountModalLabel{{ $account->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteAccountModalLabel{{ $account->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <strong class="text-danger">
                                    {{ $account->name ?? 'This account' }}
                                </strong> will be permanently deleted. Are you sure?
                            </p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash-fill me-1"></i> Yes, delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach



        {{-- Edit Modals --}}
            @foreach ($accounts as $account)
            <div class="modal fade" id="editAccountModal{{ $account->id }}" tabindex="-1"
                aria-labelledby="editAccountModalLabel{{ $account->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('accounts.update', $account->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editAccountModalLabel{{ $account->id }}">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Bank Account
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Account Name -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name{{ $account->id }}" name="name"
                                        value="{{ old('name', $account->name) }}" required>
                                    <label for="name{{ $account->id }}">Account Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Bank Name -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                        id="bank_name{{ $account->id }}" name="bank_name"
                                        value="{{ old('bank_name', $account->bank_name) }}" required>
                                    <label for="bank_name{{ $account->id }}">Bank Name</label>
                                    @error('bank_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Account Type -->
                                <div class="form-floating mb-3">
                                    <select class="form-select @error('account_type') is-invalid @enderror"
                                        id="account_type{{ $account->id }}" name="account_type" required>
                                        @foreach(App\Enums\AccountType::cases() as $type)
                                            <option value="{{ $type->value }}"
                                                {{ old('account_type', $account->account_type) == $type->value ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $type->value)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="account_type{{ $account->id }}">Account Type</label>
                                    @error('account_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Initial Balance -->
                                <div class="form-floating mb-3">
                                    <input type="number" step="0.01" class="form-control @error('initial_balance') is-invalid @enderror"
                                        id="initial_balance{{ $account->id }}" name="initial_balance"
                                        value="{{ old('initial_balance', $account->initial_balance) }}" required>
                                    <label for="initial_balance{{ $account->id }}">Initial Balance</label>
                                    @error('initial_balance')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="bi bi-save me-1"></i> Update
                                </button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

            @foreach ($accounts as $account)
            <!-- Modal de détail du compte bancaire -->
            <div class="modal fade" id="showAccountModal{{ $account->id }}" tabindex="-1"
                aria-labelledby="showAccountModalLabel{{ $account->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="showAccountModalLabel{{ $account->id }}">
                                <i class="bi bi-bank2 me-2"></i> Account Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
            
                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p><i class="bi bi-person-badge-fill me-2 text-primary"></i><strong>Name:</strong>
                                        {{ $account->name }}</p>
                                    <p><i class="bi bi-building me-2 text-primary"></i><strong>Bank Name:</strong>
                                        {{ $account->bank_name }}</p>
                                    <p><i class="bi bi-wallet2 me-2 text-primary"></i><strong>Account Type:</strong>
                                        <span class="badge bg-info text-dark">{{ $account->account_type }}</span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="bi bi-cash-coin me-2 text-primary"></i><strong>Initial Balance:</strong>
                                        <span class="text-success fw-bold">{{ number_format($account->initial_balance, 2) }} FCFA</span>
                                    </p>
                                    <p><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Created At:</strong>
                                        {{ $account->created_at->format('d M Y') }}</p>
                                    <p><i class="bi bi-calendar-check me-2 text-primary"></i><strong>Last Update:</strong>
                                        {{ $account->updated_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
            
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            

    </div>
    </div>

    </div>

@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
    <script src="{{asset('assets/js/account.js')}}"></script>
@endsection