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
                    <img src="{{asset('assets/img/budget.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Budgets</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <!-- Bouton pour ouvrir le modal de création de budget -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBudgetModal">
                    <i class="fas fa-plus me-1"></i> Add Budget
                </button>

                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search budget...">
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @if($budgets->isEmpty())
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle-fill me-2"></i> No budget found.
                    </div>
                @else
                    <div class="table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead class="table-info">
                                <tr>
                                    <th>Activity</th>
                                    <th>Amount</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="Table">
                                @foreach ($budgets as $budget)
                                    <tr>
                                        <!-- Nom de l'activité -->
                                        <td>{{ $budget->activity->name ?? 'N/A' }}</td>
            
                                        <!-- Montant -->
                                        <td><span class="badge bg-primary">{{ number_format($budget->amount, 2) }} FCFA</span></td>
            
                                        <!-- Date de début -->
                                        <td>{{ \Carbon\Carbon::parse($budget->start_date)->format('d M Y') }}</td>
            
                                        <!-- Date de fin -->
                                        <td>{{ \Carbon\Carbon::parse($budget->end_date)->format('d M Y') }}</td>
            
                                        <!-- Description -->
                                        @if (!empty($budget->description))
                                            <td>{{ $budget->description }}</td>
                                        @else
                                            <td><span class="badge bg-secondary">No description</span></td>
                                        @endif
            
                                        <!-- Actions -->
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editBudgetModal{{ $budget->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
            
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteBudgetModal{{ $budget->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
            
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showBudgetModal{{ $budget->id }}">
                                                <i class="bi bi-eye-fill"></i>
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
                    <button class="btn btn-primary me-3" id="prevButton" disabled>Previous</button>
            
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination">
                            <!-- Pagination dynamique ici -->
                        </ul>
                    </nav>
            
                    <button class="btn btn-primary ms-3" id="nextButton" disabled>Next</button>
                </div>
            </div>
            
        </div>

        <!-- Modal pour ajouter un budget -->
        <!-- Modal pour la création d’un budget -->
        <div class="modal fade" id="createBudgetModal" tabindex="-1" aria-labelledby="createBudgetModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('budgets.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createBudgetModalLabel">Create Budget</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Nom du budget -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required placeholder="Enter budget name">
                                <label for="name">Budget Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <!-- Date de début -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}" required
                                    placeholder="Start date">
                                <label for="start_date">Start Date</label>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date de fin -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}" required
                                    placeholder="End date">
                                <label for="end_date">End Date</label>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Activité liée -->
                            <div class="form-floating mb-3">
                                <select name="id_activity" id="id_activity"
                                    class="form-select @error('id_activity') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select an activity</option>
                                    @foreach ($activities as $activity)
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
                            <button type="submit" class="btn btn-primary w-100">Create Budget</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit Budget Modal -->
            @foreach ($budgets as $budget)

            <div class="modal fade" id="editBudgetModal{{ $budget->id }}" tabindex="-1" role="dialog"
                aria-labelledby="editBudgetModalLabel{{ $budget->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editBudgetModalLabel{{ $budget->id }}">Edit Budget</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <form method="POST" action="{{ route('budgets.update', $budget->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="modal-body bg-light">
                                {{-- Activity --}}
                                <div class="form-floating mb-3">
                                    <select name="id_activity" id="id_activity{{ $budget->id }}"
                                        class="form-select @error('id_activity') is-invalid @enderror" required>
                                        <option value="">Select Activity</option>
                                        @foreach ($activities as $activity)
                                            <option value="{{ $activity->id }}"
                                                {{ old('id_activity', $budget->id_activity) == $activity->id ? 'selected' : '' }}>
                                                {{ $activity->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="id_activity{{ $budget->id }}">Activity</label>
                                    @error('id_activity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Amount --}}
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                        id="amount{{ $budget->id }}" name="amount"
                                        value="{{ old('amount', $budget->amount) }}" required step="0.01"
                                        placeholder="Enter amount">
                                    <label for="amount{{ $budget->id }}">Amount</label>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Start Date --}}
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date{{ $budget->id }}" name="start_date"
                                        value="{{ old('start_date', $budget->start_date) }}" required>
                                    <label for="start_date{{ $budget->id }}">Start Date</label>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- End Date --}}
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date{{ $budget->id }}" name="end_date"
                                        value="{{ old('end_date', $budget->end_date) }}" required>
                                    <label for="end_date{{ $budget->id }}">End Date</label>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Description --}}
                                <div class="form-floating mb-3">
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Enter description" id="description{{ $budget->id }}" name="description"
                                        style="height: 100px">{{ old('description', $budget->description) }}</textarea>
                                    <label for="description{{ $budget->id }}">Description</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Update Budget</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

                        <!-- Modal de confirmation de suppression des budgets -->
            @foreach ($budgets as $budget)

            <div class="modal fade" id="deleteBudgetModal{{ $budget->id }}" tabindex="-1"
                aria-labelledby="deleteBudgetModalLabel{{ $budget->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteBudgetModalLabel{{ $budget->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong class="text-danger">
                                {{ $budget->activity->name ?? 'This budget' }}
                            </strong> will be permanently deleted. Are you sure?</p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('budgets.destroy', $budget->id) }}" method="POST" class="d-inline">
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

            @foreach ($budgets as $budget)
    <!-- Modal de détail du budget -->
                <div class="modal fade" id="showBudgetModal{{ $budget->id }}" tabindex="-1"
                    aria-labelledby="showBudgetModalLabel{{ $budget->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content rounded-4 shadow-lg">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="showBudgetModalLabel{{ $budget->id }}">
                                    <i class="bi bi-wallet-fill me-2"></i> Budget Details
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <p><i class="bi bi-person-circle me-2 text-primary"></i><strong>User:</strong>
                                            {{ $budget->user->name ?? 'N/A' }}</p>
                                        <p><i class="bi bi-briefcase-fill me-2 text-primary"></i><strong>Activity:</strong>
                                            {{ $budget->activity->name ?? 'N/A' }}</p>
                                        <p><i class="bi bi-currency-dollar me-2 text-primary"></i><strong>Amount:</strong>
                                            {{ number_format($budget->amount, 2) }} FCFA</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Start Date:</strong>
                                            {{ \Carbon\Carbon::parse($budget->start_date)->format('d M Y') }}</p>
                                        <p><i class="bi bi-calendar-check me-2 text-primary"></i><strong>End Date:</strong>
                                            {{ \Carbon\Carbon::parse($budget->end_date)->format('d M Y') }}</p>
                                        <p><i class="bi bi-pencil-square me-2 text-primary"></i><strong>Description:</strong>
                                            {{ !empty($budget->description) ? $budget->description : 'No description' }}</p>
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