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
                    <img src="{{asset('assets/img/financial-goals.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Financial Goals</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <!-- Bouton pour ouvrir le modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGoalModal">
                    <i class="bi bi-plus cercle"></i> Create Financial Goal
                </button>

                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search Financial Goal...">
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="card-body px-0 pt-0 pb-2">
                    @if($goals->isEmpty())
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle-fill me-2"></i> No finacial goal found.
                    </div>
                @else
                    <div class="table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Target Amount</th>
                                    <th>Current Balance</th>
                                    <th>Deadline</th>
                                    <th>Description</th>
                                    <th>Status</th> {{-- Colonne ajoutée --}}
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="Table">
                                @forelse ($goals as $goal)
                                    <tr>
                                        <td>{{ $goal->name }}</td>
                    
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ number_format($goal->target_amount, 2) }} FCFA
                                            </span>
                                        </td>
                    
                                        <td class="text-success fw-bold">
                                            +{{ number_format($goal->current_balance, 2) }} FCFA
                                        </td>
                    
                                        <td>
                                            {{ \Carbon\Carbon::parse($goal->deadline)->format('d M Y') }}
                                        </td>
                                        @if ( !empty($goal->description))
                                            <td>
                                                {{$goal->description}}
                                            </td>
                                        @else
                                            <td>
                                                <span class="badge bg-danger"> No description</span>
                                            </td>
                                        @endif
                    
                                        {{-- Nouveau champ Status --}}
                                        <td>
                                            @switch($goal->status)
                                                @case('in_progress')
                                                    <span class="badge bg-warning text-dark">In Progress</span>
                                                    @break
                                                @case('achieved')
                                                    <span class="badge bg-success">Achieved</span>
                                                    @break
                                                @case('not_achieved')
                                                    <span class="badge bg-danger">Not Achieved</span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary">Unknown</span>
                                            @endswitch
                                        </td>
                    
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editFinancialGoalModal{{ $goal->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                    
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteGoalModal{{ $goal->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#showFinancialGoalModal{{ $goal->id }}">
                                                <i class="bi bi-eye"></i>
                                            </button>                                            
                                        </td>
                                    </tr>
                    
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No financial goals found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
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

        <!-- Modal pour la création de l'objectif financier -->
        <div class="modal fade" id="createGoalModal" tabindex="-1" aria-labelledby="createGoalModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('financial_goals.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createGoalModalLabel">Create Financial Goal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Nom de l'objectif financier -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required placeholder="Enter goal name">
                                <label for="name">Goal Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Montant cible -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                    id="target_amount" name="target_amount" value="{{ old('target_amount') }}" required
                                    step="0.01" placeholder="Enter target amount">
                                <label for="target_amount">Target Amount</label>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Montant actuel -->
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('current_amount') is-invalid @enderror"
                                    id="current_amount" name="current_amount" value="{{ old('current_amount') }}" required
                                    step="0.01" placeholder="Enter current amount">
                                <label for="current_amount">Current Amount</label>
                                @error('current_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Date limite -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline" name="deadline" value="{{ old('deadline') }}" required
                                    placeholder="Select a deadline">
                                <label for="deadline">Deadline</label>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="form-floating mb-3">
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In
                                        Progress</option>
                                    <option value="achieved" {{ old('status') == 'achieved' ? 'selected' : '' }}>Achieved
                                    </option>
                                    <option value="not_achieved" {{ old('status') == 'not_achieved' ? 'selected' : '' }}>Not
                                        Achieved</option>
                                </select>
                                <label for="status">Status</label>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

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
                            <button type="submit" class="btn btn-primary w-100">Create Goal</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Edit Financial Goal Modal -->
        @foreach ($goals as $goal)

        <div class="modal fade" id="editFinancialGoalModal{{ $goal->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editFinancialGoalModalLabel{{ $goal->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editFinancialGoalModalLabel{{ $goal->id }}">Edit Financial Goal</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
    
                    <form method="POST" action="{{ route('financial_goals.update', $goal->id) }}">
                        @csrf
                        @method('PUT')
    
                        <div class="modal-body bg-light">
                            {{-- Name --}}
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name{{ $goal->id }}" name="name" value="{{ old('name', $goal->name) }}" required
                                    placeholder="Goal name">
                                <label for="name{{ $goal->id }}">Goal Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- Target Amount --}}
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('target_amount') is-invalid @enderror"
                                    id="target_amount{{ $goal->id }}" name="target_amount"
                                    value="{{ old('target_amount', $goal->target_amount) }}" required step="0.01"
                                    placeholder="Enter target amount">
                                <label for="target_amount{{ $goal->id }}">Target Amount</label>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- Current Amount --}}
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('current_amount') is-invalid @enderror"
                                    id="current_amount{{ $goal->id }}" name="current_amount"
                                    value="{{ old('current_amount', $goal->current_amount) }}" required step="0.01"
                                    placeholder="Enter current amount">
                                <label for="current_amount{{ $goal->id }}">Current Amount</label>
                                @error('current_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- Deadline --}}
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('deadline') is-invalid @enderror"
                                    id="deadline{{ $goal->id }}" name="deadline"
                                    value="{{ old('deadline', $goal->deadline) }}" required>
                                <label for="deadline{{ $goal->id }}">Deadline</label>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- Description --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter description" id="description{{ $goal->id }}" name="description"
                                    style="height: 100px">{{ old('description', $goal->description) }}</textarea>
                                <label for="description{{ $goal->id }}">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                            {{-- Status --}}
                            <div class="form-floating mb-3">
                                <select name="status" id="status{{ $goal->id }}"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="in_progress"
                                        {{ old('status', $goal->status) == 'in_progress' ? 'selected' : '' }}>
                                        In Progress
                                    </option>
                                    <option value="achieved"
                                        {{ old('status', $goal->status) == 'achieved' ? 'selected' : '' }}>
                                        Achieved
                                    </option>
                                    <option value="not_achieved"
                                        {{ old('status', $goal->status) == 'not_achieved' ? 'selected' : '' }}>
                                        Not Achieved
                                    </option>
                                </select>
                                <label for="status{{ $goal->id }}">Status</label>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
    
                        </div>
    
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update Goal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    


        <!-- Modal de confirmation de suppression -->
        @foreach ($goals as $goal)

            <div class="modal fade" id="deleteGoalModal{{ $goal->id }}" tabindex="-1"
                aria-labelledby="deleteGoalModalLabel{{ $goal->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="deleteGoalModalLabel{{ $goal->id }}">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong class="text-danger">{{ $goal->name }}</strong> will be permanently deleted. Are you sure?
                            </p>
                            <p class="text-muted">This action cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                            </button>
                            <form action="{{ route('financial_goals.destroy', $goal->id) }}" method="POST" class="d-inline">
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



        @foreach ($goals as $goal)
    <!-- Modal de détail -->
    <div class="modal fade" id="showFinancialGoalModal{{ $goal->id }}" tabindex="-1"
        aria-labelledby="showFinancialGoalModalLabel{{ $goal->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="showFinancialGoalModalLabel{{ $goal->id }}">
                        <i class="bi bi-basket2-fill me-2"></i> Goal Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p><i class="bi bi-person-circle me-2 text-primary"></i><strong>User:</strong>
                                {{ $goal->user->name ?? 'N/A' }}</p>
                            <p><i class="bi bi-type me-2 text-primary"></i><strong>Name:</strong>
                                {{ $goal->name }}</p>
                            <p><i class="bi bi-currency-dollar me-2 text-primary"></i><strong>Target Amount:</strong>
                                {{ number_format($goal->target_amount, 2) }} FCFA</p>
                            <p><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Deadline:</strong>
                                {{ \Carbon\Carbon::parse($goal->deadline)->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-graph-up-arrow me-2 text-primary"></i><strong>Current Balance:</strong>
                                {{ number_format($goal->current_balance, 2) }} FCFA</p>
                            <p><i class="bi bi-check-circle me-2 text-primary"></i><strong>Status:</strong>
                                <span class="badge
                                    @if($goal->status == 'in_progress') bg-warning
                                    @elseif($goal->status == 'achieved') bg-success
                                    @elseif($goal->status == 'not_achieved') bg-danger
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $goal->status)) }}
                                </span>
                            </p>
                            <p><i class="bi bi-pencil-square me-2 text-primary"></i><strong>Description:</strong>
                                {{ !empty($goal->description) ? $goal->description : 'No description' }}</p>
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