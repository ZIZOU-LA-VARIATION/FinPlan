@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-5">

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
                    <img src="{{asset('assets/img/loan.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-danger mb-4">Debts</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <!-- Bouton pour ouvrir le modal de création -->
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createDebtModal">
                    <i class="bi bi-plus-circle me-1"></i> Add New Debt
                </button>

                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search debts...">
            </div>

            <!-- Tableau des budgets -->
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Creditor</th>
                                <th>Amount</th>
                                <th>Remaining</th>
                                <th>Loan Date</th>
                                <th>Due Date</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="Table">
                            @forelse ($debts as $debt)
                                <tr>
                                    <td>{{ $debt->creditor }}</td>
                
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ number_format($debt->amount, 2) }} FCFA
                                        </span>
                                    </td>
                
                                    <td class="text-danger fw-bold">
                                        -{{ number_format($debt->remaining_amount, 2) }} FCFA
                                    </td>
                
                                    <td>
                                        {{ \Carbon\Carbon::parse($debt->loan_date)->format('d M Y') }}
                                    </td>
                
                                    <td>
                                        {{ \Carbon\Carbon::parse($debt->due_date)->format('d M Y') }}
                                    </td>
                
                                    @if (!empty($debt->description))
                                        <td>{{ $debt->description }}</td>
                                    @else
                                        <td>
                                            <span class="badge bg-danger">No description</span>
                                        </td>
                                    @endif
                
                                    <td>
                                        @switch($debt->status)
                                            @case('unpaid')
                                                <span class="badge bg-danger">Unpaid</span>
                                                @break
                                            @case('partially_paid')
                                                <span class="badge bg-warning text-dark">Partially Paid</span>
                                                @break
                                            @case('paid')
                                                <span class="badge bg-success">Paid</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Unknown</span>
                                        @endswitch
                                    </td>
                
                                    <td>
                                        <!-- Edit button -->
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editDebtModal{{ $debt->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    
                                        <!-- Delete button -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteDebtModal{{ $debt->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    
                                        <!-- Show button -->
                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showDebtModal{{ $debt->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No debts found.</td>
                                </tr>
                            @endforelse
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

        <!-- Modal pour la création d'une dette -->
        <div class="modal fade" id="createDebtModal" tabindex="-1" aria-labelledby="createDebtModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('debts.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createDebtModalLabel">Create Debt</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Creditor -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('creditor') is-invalid @enderror"
                                    id="creditor" name="creditor" value="{{ old('creditor') }}" required
                                    placeholder="Enter creditor name">
                                <label for="creditor">Creditor</label>
                                @error('creditor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Amount -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                    name="amount" value="{{ old('amount') }}" required step="0.01"
                                    placeholder="Enter amount">
                                <label for="amount">Total Amount</label>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remaining Amount -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('remaining_amount') is-invalid @enderror"
                                    id="remaining_amount" name="remaining_amount" value="{{ old('remaining_amount') }}"
                                    required step="0.01" placeholder="Enter remaining amount">
                                <label for="remaining_amount">Remaining Amount</label>
                                @error('remaining_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Loan Date -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('loan_date') is-invalid @enderror"
                                    id="loan_date" name="loan_date" value="{{ old('loan_date') }}" required>
                                <label for="loan_date">Loan Date</label>
                                @error('loan_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                <label for="due_date">Due Date</label>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="form-floating mb-3">
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="partially_paid" {{ old('status') == 'partially_paid' ? 'selected' : '' }}>
                                        Partially Paid</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <label for="status">Status</label>
                                @error('status')
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
                            <button type="submit" class="btn btn-primary w-100">Create Debt</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal de confirmation de suppression pour chaque dette -->
        @foreach ($debts as $debt)
            <div class="modal fade" id="deleteDebtModal{{ $debt->id }}" tabindex="-1"
                aria-labelledby="deleteDebtModalLabel{{ $debt->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteDebtModalLabel{{ $debt->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong class="text-danger">{{ $debt->creditor }}</strong> will be permanently deleted. Are you sure?</p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('debts.destroy', $debt->id) }}" method="POST" class="d-inline">
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




        @foreach ($debts as $debt)
                        <!-- Modal Edit Debt -->
            <div class="modal fade" id="editDebtModal{{ $debt->id }}" tabindex="-1" aria-labelledby="editDebtModalLabel{{ $debt->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('debts.update', $debt->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Debt</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="creditor" name="creditor" value="{{ $debt->creditor }}" required>
                                    <label for="creditor">Creditor</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="amount" value="{{ $debt->amount }}" step="0.01" required>
                                    <label for="amount">Total Amount</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" name="remaining_amount" value="{{ $debt->remaining_amount }}" step="0.01" required>
                                    <label for="remaining_amount">Remaining Amount</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="loan_date" value="{{ $debt->loan_date }}" required>
                                    <label for="loan_date">Loan Date</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" name="due_date" value="{{ $debt->due_date }}" required>
                                    <label for="due_date">Due Date</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select name="status" class="form-select" required>
                                        <option value="unpaid" {{ $debt->status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="partially_paid" {{ $debt->status == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                                        <option value="paid" {{ $debt->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <textarea name="description" class="form-control" style="height: 100px">{{ $debt->description }}</textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Update Debt</button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @endforeach



        @foreach ($debts as $debt)
        <!-- Modal de détail -->
        <div class="modal fade" id="showDebtModal{{ $debt->id }}" tabindex="-1"
            aria-labelledby="showDebtModalLabel{{ $debt->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="showDebtModalLabel{{ $debt->id }}">
                            <i class="bi bi-cash-coin me-2"></i> Debt Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-person-circle me-2 text-primary"></i><strong>User:</strong>
                                    {{ $debt->user->name ?? 'N/A' }}</p>
                                <p><i class="bi bi-person-fill-exclamation me-2 text-primary"></i><strong>Creditor:</strong>
                                    {{ $debt->creditor }}</p>
                                <p><i class="bi bi-currency-dollar me-2 text-primary"></i><strong>Amount:</strong>
                                    {{ number_format($debt->amount, 2) }} FCFA</p>
                                <p><i class="bi bi-calendar2-plus me-2 text-primary"></i><strong>Loan Date:</strong>
                                    {{ \Carbon\Carbon::parse($debt->loan_date)->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-piggy-bank-fill me-2 text-primary"></i><strong>Remaining:</strong>
                                    {{ number_format($debt->remaining_amount, 2) }} FCFA</p>
                                <p><i class="bi bi-calendar2-check me-2 text-primary"></i><strong>Due Date:</strong>
                                    {{ \Carbon\Carbon::parse($debt->due_date)->format('d M Y') }}</p>
                                <p><i class="bi bi-check2-circle me-2 text-primary"></i><strong>Status:</strong>
                                    <span class="badge
                                        @if($debt->status == 'pending') bg-warning text-dark
                                        @elseif($debt->status == 'paid') bg-success
                                        @elseif($debt->status == 'overdue') bg-danger
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $debt->status)) }}
                                    </span>
                                </p>
                                <p><i class="bi bi-journal-text me-2 text-primary"></i><strong>Description:</strong>
                                    {{ !empty($debt->description) ? $debt->description : 'No description' }}</p>
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

@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection