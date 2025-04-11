@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-4">


            @if ($errors->any())
                <div class="alert alert-danger position-relative">

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success position-relative">
                    {{ session('success') }}
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif

            <div class="aligne">
                <div>
                    <img src="../assets/img/transaction.png" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Transactions</span>
                </h2><br><br><br><br><br>
            </div>


            <div class="transaction-header mb-3">
                <!-- Bouton pour ouvrir le modal de création de transaction -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#createTransactionModal">
                    <i class="fas fa-plus me-1"></i> Add Transaction
                </button>

                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search transaction...">
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            @if($transactions->isEmpty())
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle-fill me-2"></i> No transaction found.
                </div>
            @else
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="table-info">
                            <tr>
                                <th>Activity</th>
                                <th>Account</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="Table">
                            @forelse ($transactions as $transaction)
                                <tr>
                                    <!-- Nom de l'activité -->
                                    <td>{{ $transaction->activity->name ?? 'N/A' }}</td>

                                    <!-- Nom du compte bancaire -->
                                    <td>{{ $transaction->account->name ?? 'N/A' }}</td>

                                    <!-- Date -->
                                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>

                                    <!-- Montant -->
                                    <td>
                                        @if($transaction->type === 'income')
                                            <span class="badge bg-success">+{{ number_format($transaction->amount, 2) }} FCFA</span>
                                        @else
                                            <span class="badge bg-danger">-{{ number_format($transaction->amount, 2) }} FCFA</span>
                                        @endif
                                    </td>

                                    <!-- Type -->
                                    <td>
                                        @if($transaction->type === 'income')
                                            <span class="badge bg-success">Income</span>
                                        @else
                                            <span class="badge bg-danger">Expense</span>
                                        @endif
                                    </td>

                                    <!-- Description -->
                                    @if (!empty($transaction->description))
                                        <td>{{ $transaction->description }}</td>
                                    @else
                                        <td><span class="badge bg-secondary">No description</span></td>
                                    @endif

                                    <!-- Actions -->
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editTransactionModal{{ $transaction->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>


                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteTransactionModal{{ $transaction->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- Bouton pour ouvrir le modal de détail -->
                                        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#showTransactionModal{{ $transaction->id }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No transactions found.</td>
                                </tr>
                            @endforelse
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

        <!-- Modal pour la création d'une transaction -->
        <div class="modal fade" id="createTransactionModal" tabindex="-1" aria-labelledby="createTransactionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createTransactionModalLabel">Create Transaction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Montant -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                    name="amount" value="{{ old('amount') }}" required step="0.01"
                                    placeholder="Enter amount">
                                <label for="amount">Amount</label>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                    name="date" value="{{ old('date') }}" required placeholder="Enter date">
                                <label for="date">Date</label>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="form-floating mb-3">
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                                    required>
                                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                </select>
                                <label for="type">Type</label>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Activité -->
                            <div class="form-floating mb-3">
                                <select name="id_activity" id="id_activity"
                                    class="form-select @error('id_activity') is-invalid @enderror" required>
                                    <option value="" disabled selected>Choose activity</option>
                                    @foreach($activities as $activity)
                                        <option value="{{ $activity->id }}" {{ old('id_activity') == $activity->id ? 'selected' : '' }}>
                                            {{ $activity->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_activity">Activity</label>
                                @error('id_activity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Compte bancaire -->
                            <div class="form-floating mb-3">
                                <select name="id_account" id="id_account"
                                    class="form-select @error('id_account') is-invalid @enderror" required>
                                    <option value="" disabled selected>Choose account</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('id_account') == $account->id ? 'selected' : '' }}>
                                            {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_account">Bank Account</label>
                                @error('id_account')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter a description" id="description" name="description"
                                    style="height: 100px">{{ old('description') }}</textarea>
                                <label for="description">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Create Transaction</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- Modal pour l'édition d'une transaction -->
            @foreach ($transactions as $transaction)
            <div class="modal fade" id="editTransactionModal{{ $transaction->id }}" tabindex="-1"
                aria-labelledby="editTransactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                            @csrf
                            @method('PUT')
        
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editTransactionModalLabel{{ $transaction->id }}">Edit Transaction</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
        
                            <div class="modal-body bg-light">
                                {{-- Activity --}}
                                <div class="form-floating mb-3">

                                    <select class="form-select" id="id_activity{{ $transaction->id }}" name="id_activity" required>
                                        @foreach ($activities as $activity)
                                            <option value="{{ $activity->id }}" {{ $transaction->id_activity == $activity->id ? 'selected' : '' }}>
                                                {{ $activity->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_activity{{ $transaction->id }}">Activity</label>
                                </div>
        
                                {{-- Bank Account --}}
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="id_account{{ $transaction->id }}" name="id_account" required>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}" {{ $transaction->id_account == $account->id ? 'selected' : '' }}>
                                                {{ $account->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_account{{ $transaction->id }}">Bank Account</label>
                                </div>
        
                                {{-- Date --}}
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="date{{ $transaction->id }}" name="date"
                                        value="{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}" required>
                                    <label for="date{{ $transaction->id }}">Date</label>
                                </div>
        
                                {{-- Amount --}}
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="amount{{ $transaction->id }}" name="amount"
                                        step="0.01" value="{{ $transaction->amount }}" required>
                                    <label for="amount{{ $transaction->id }}">Amount</label>
                                </div>
        
                                {{-- Type --}}
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="type{{ $transaction->id }}" name="type" required>
                                        <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                                        <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Expense</option>
                                    </select>
                                    <label for="type{{ $transaction->id }}">Transaction Type</label>
                                </div>
        
                                {{-- Description --}}
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" id="description{{ $transaction->id }}" name="description"
                                        style="height: 100px">{{ $transaction->description }}</textarea>
                                    <label for="description{{ $transaction->id }}">Description</label>
                                </div>
                            </div>
        
                            <div class="modal-footer bg-light">
                                <button type="submit" class="btn btn-success">Update Transaction</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        

        {{-- show --}}
        @foreach ($transactions as $transaction)
            <!-- Modal de détail de transaction -->
            <div class="modal fade" id="showTransactionModal{{ $transaction->id }}" tabindex="-1"
                aria-labelledby="showTransactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="showTransactionModalLabel{{ $transaction->id }}">
                                <i class="bi bi-eye-fill me-2"></i> Transaction Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p><i class="bi bi-person-circle me-2 text-info"></i><strong>User:</strong>
                                        {{ $transaction->user->name ?? 'N/A' }}</p>
                                    <p><i class="bi bi-type me-2 text-info"></i><strong>Label:</strong>
                                        {{ $transaction->label }}</p>
                                    <p><i class="bi bi-cash-coin me-2 text-info"></i><strong>Amount:</strong>
                                        {{ number_format($transaction->amount, 2) }} FCFA</p>
                                    <p><i class="bi bi-calendar-event me-2 text-info"></i><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="bi bi-wallet2 me-2 text-info"></i><strong>Account:</strong>
                                        {{ $transaction->account->name ?? 'N/A' }}</p>
                                    <p><i class="bi bi-tag me-2 text-info"></i><strong>Category:</strong>
                                        {{ $transaction->category->name ?? 'N/A' }}</p>
                                    <p><i class="bi bi-pencil-square me-2 text-info"></i><strong>Description:</strong>
                                        {{ !empty($transaction->description) ? $transaction->description : 'No description' }}</p>
                                    <p><i class="bi bi-arrow-left-right me-2 text-info"></i><strong>Type:</strong>
                                        <span class="badge
                                            @if($transaction->type == 'income') bg-success
                                            @elseif($transaction->type == 'expense') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </p>
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

    <!-- Modal de confirmation de suppression -->
        @foreach ($transactions as $transaction)

            <div class="modal fade" id="deleteTransactionModal{{ $transaction->id }}" tabindex="-1"
                aria-labelledby="deleteTransactionModalLabel{{ $transaction->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteTransactionModalLabel{{ $transaction->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <strong class="text-danger">{{ $transaction->name }}</strong> will be permanently deleted.
                                Are you sure?
                            </p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="d-inline">
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


    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection