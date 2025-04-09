@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
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

        <div class="container mt-5">

            @if(session('success'))
                <div class="alert alert-success position-relative">
                    {{ session('success') }}
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
            @endif


            <div class="aligne">
                <div>
                    <img src="{{asset('assets/img/saving.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Investisment</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <!-- Button to trigger the modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#createInvestmentModal">
                    <i class="bi bi-circle"></i>
                </button>


                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search Investisment...">
            </div>

            <!-- Tableau des investissements -->
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Investment Date</th>
                                <th>Status</th>
                                <th>Actual Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="Table">
                            @forelse ($investments as $investment)
                                <tr>
                                    <td>{{ $investment->name }}</td>
                                    <td class="text-primary fw-bold">+{{ number_format($investment->amount, 2) }} FCFA</td>
                                    <td><span class="badge bg-info text-dark">{{ ucfirst($investment->type) }}</span></td>
                                    <td>{{ $investment->investment_date }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                                                                                                                            @if($investment->status == 'paid') bg-success
                                                                                                                                            @elseif($investment->status == 'on_hold') bg-secondary
                                                                                                                                            @elseif($investment->status == 'pending') bg-warning text-dark
                                                                                                                                            @elseif($investment->status == 'lost') bg-danger
                                                                                                                                            @endif
                                                                                                                                        ">
                                            {{ ucfirst(str_replace('_', ' ', $investment->status)) }}
                                        </span>
                                    </td>
                                    <td class="text-success fw-bold">{{ number_format($investment->current_value, 2) }} FCFA
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editInvestmentModal{{ $investment->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('investments.destroy', $investment->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Bouton supprimer -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $investment->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#showInvestmentModal{{ $investment->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>



                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No investments found.</td>
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

        <!-- Modal -->
        <div class="modal fade" id="createInvestmentModal" tabindex="-1" role="dialog"
            aria-labelledby="createInvestmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createInvestmentModalLabel">Create New Investment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('investments.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="id_user">User</label>
                                <select name="id_user" id="id_user"
                                    class="form-control @error('id_user') is-invalid @enderror">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Investment Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount"
                                    name="amount" value="{{ old('amount') }}" required step="0.01">
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="type">Investment Type</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                                    required>
                                    <option value="stock" {{ old('type') == 'stock' ? 'selected' : '' }}>Stock</option>
                                    <option value="bond" {{ old('type') == 'bond' ? 'selected' : '' }}>Bond</option>
                                    <option value="mutual fund" {{ old('type') == 'mutual fund' ? 'selected' : '' }}>Mutual
                                        Fund</option>
                                    <option value="cryptocurrency" {{ old('type') == 'cryptocurrency' ? 'selected' : '' }}>
                                        Cryptocurrency</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="investment_date">Investment Date</label>
                                <input type="date" class="form-control @error('investment_date') is-invalid @enderror"
                                    id="investment_date" name="investment_date" value="{{ old('investment_date') }}"
                                    required>
                                @error('investment_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror"
                                    required>
                                    <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold
                                    </option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="current_value">Current Value</label>
                                <input type="number" class="form-control @error('current_value') is-invalid @enderror"
                                    id="current_value" name="current_value" value="{{ old('current_value') }}" required
                                    step="0.01">
                                @error('current_value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Create Investment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($investments as $investment)
            <!-- Modal d'édition pour chaque investissement -->

            <div class="modal fade" id="editInvestmentModal{{ $investment->id }}" tabindex="-1"
                aria-labelledby="editInvestmentModalLabel{{ $investment->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <form method="POST" action="{{ route('investments.update', $investment->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="editInvestmentModalLabel{{ $investment->id }}">
                                    <i class="bi bi-pencil-fill me-2"></i> Edit Investment
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label for="id_user" class="form-label">User</label>
                                    <select name="id_user" class="form-control" required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $investment->id_user == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Investment Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $investment->name }}" required>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" name="amount" step="0.01" value="{{ $investment->amount }}" required>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select name="type" class="form-control" required>
                                        @foreach (['stock', 'bond', 'mutual fund', 'cryptocurrency'] as $type)
                                            <option value="{{ $type }}" {{ $investment->type == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="investment_date" class="form-label">Investment Date</label>
                                    <input type="date" class="form-control" name="investment_date" value="{{ $investment->investment_date }}" required>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" class="form-control" required>
                                        @foreach (['on_hold', 'pending', 'paid', 'lost'] as $status)
                                            <option value="{{ $status }}" {{ $investment->status == $status ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <div class="form-group mb-3">
                                    <label for="current_value" class="form-label">Current Value</label>
                                    <input type="number" class="form-control" name="current_value" step="0.01" value="{{ $investment->current_value }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-1"></i> Update
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        @endforeach

        @foreach ($investments as $investment)
            <!-- Modal de confirmation -->
            <div class="modal fade" id="deleteModal{{ $investment->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $investment->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteModalLabel{{ $investment->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong class="text-danger">{{ $investment->name }}</strong> will be permanently deleted. Are you
                                sure?</p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('investments.destroy', $investment->id) }}" method="POST" class="d-inline">
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



        <!-- Modal de détail -->
        @foreach ($investments as $investment)

            <div class="modal fade" id="showInvestmentModal{{ $investment->id }}" tabindex="-1"
                aria-labelledby="showInvestmentModalLabel{{ $investment->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="showInvestmentModalLabel{{ $investment->id }}">
                                <i class="bi bi-cash-coin me-2"></i> Investment Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p><i class="bi bi-person-circle me-2 text-primary"></i><strong>User:</strong>
                                        {{ $investment->user->name ?? 'N/A' }}</p>
                                    <p><i class="bi bi-type me-2 text-primary"></i><strong>Name:</strong>
                                        {{ $investment->name }}</p>
                                    <p><i class="bi bi-currency-dollar me-2 text-primary"></i><strong>Amount:</strong>
                                        {{ number_format($investment->amount, 2) }} FCFA</p>
                                    <p><i class="bi bi-graph-up-arrow me-2 text-primary"></i><strong>Type:</strong>
                                        {{ ucfirst($investment->type) }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Date:</strong>
                                        {{ $investment->investment_date }}</p>
                                    <p><i class="bi bi-flag me-2 text-primary"></i><strong>Status:</strong>
                                        <span class="badge
                                                @if($investment->status == 'paid') bg-success
                                                @elseif($investment->status == 'on_hold') bg-secondary
                                                @elseif($investment->status == 'pending') bg-warning text-dark
                                                @elseif($investment->status == 'lost') bg-danger
                                                @endif">
                                            {{ ucfirst(str_replace('_', ' ', $investment->status)) }}
                                        </span>
                                    </p>
                                    <p><i class="bi bi-currency-exchange me-2 text-primary"></i><strong>Current Value:</strong>
                                        {{ number_format($investment->current_value, 2) }} FCFA</p>
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