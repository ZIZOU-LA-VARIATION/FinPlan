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
                                        <a href="{{route('accounts.edit', ['account' => $account])}}">
                                            <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                        </a>

                                        <!-- Delete Button -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmationModal" data-account-id="{{ $account->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <a href="{{ route('accounts.show', ['account' => $account->id]) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

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

        {{-- <a href="{{ route('accounts.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Retour
        </a> --}}


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



        <!-- Delete Confirmation Modal -->
        <!-- Fenêtre modale de confirmation de suppression -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Do you want to delete this bank account ?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteAccountForm" action="{{route('accounts.destroy', $account->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    </div>

@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
    <script src="{{asset('assets/js/account.js')}}"></script>
@endsection