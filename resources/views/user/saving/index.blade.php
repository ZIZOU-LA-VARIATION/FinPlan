@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-5">
            <div class="aligne">
                <div>
                    <img src="{{asset('assets/img/saving.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Savings</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                    data-bs-target="#createSavingModal">
                    <i class="bi bi-plus-circle"></i> Add Saving
                </button>
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search savings...">
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Saving Name</th>
                                <th>Target Amount</th>
                                <th>Current Amount</th>
                                <th>Deadline</th>
                                <th>Goal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="Table">
                            @foreach ($savings as $saving)
                                <tr>
                                    <!-- Saving name -->
                                    <td>{{ $saving->name }}</td>
                                    <td class="text-success fw-bold">{{ number_format($saving->target_amount, 2) }} FCFA</td>
                                    <td class="text-primary fw-bold">{{ number_format($saving->current_amount, 2) }} FCFA</td>
                                    <td class="text-danger fw-bold">
                                        {{ \Carbon\Carbon::parse($saving->deadline)->format('d/m/Y') }}
                                    </td>
                                    <td>{{ $saving->goal ?? '—' }}</td>
                                    <td>
                                        <!-- Edit -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editModal{{ $saving->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- Delete -->
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $saving->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <!-- View -->
                                        <button type="button" class="btn btn-info btn-sm text-white" data-bs-toggle="modal"
                                            data-bs-target="#showModal{{ $saving->id }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- ✅ Modal Edit placé DANS la boucle -->
                                <div class="modal fade" id="editModal{{ $saving->id }}" tabindex="-1"
                                    aria-labelledby="editModalLabel{{ $saving->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form method="POST" action="{{ route('savings.update', $saving->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title" id="editModalLabel{{ $saving->id }}">Edit Saving
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $saving->name }}
                                                                        " required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Target Amount</label>
                                                        <input type="number" name="target_amount" class="form-control"
                                                            value="{{ $saving->target_amount }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Current Amount</label>
                                                        <input type="number" name="current_amount" class="form-control"
                                                            value="{{ $saving->current_amount }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Deadline</label>
                                                        <input type="date" name="deadline" class="form-control"
                                                            value="{{ $saving->deadline }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Goal</label>
                                                        <textarea name="goal"
                                                            class="form-control">{{ $saving->goal }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-warning">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>

                    </table>
                </div>

                <!-- Pagination (if needed) -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $savings->links() }}
                </div>
            </div>

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


        <!-- Create Saving Modal -->
        <div class="modal fade" id="createSavingModal" tabindex="-1" aria-labelledby="createSavingModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="createSavingModalLabel">New Saving Goal</h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{ route('savings.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Saving Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                    required maxlength="55">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Target Amount -->
                            <div class="mb-3">
                                <label for="target_amount" class="form-label">Target Amount</label>
                                <input type="number" step="0.01" name="target_amount" id="target_amount"
                                    class="form-control @error('target_amount') is-invalid @enderror"
                                    value="{{ old('target_amount') }}" required>
                                @error('target_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deadline -->
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" name="deadline" id="deadline"
                                    class="form-control @error('deadline') is-invalid @enderror"
                                    value="{{ old('deadline') }}" required>
                                @error('deadline')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Goal -->
                            <div class="mb-3">
                                <label for="goal" class="form-label">Goal (optional)</label>
                                <textarea name="goal" id="goal" rows="2"
                                    class="form-control @error('goal') is-invalid @enderror">{{ old('goal') }}</textarea>
                                @error('goal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @foreach ($savings as $saving)
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal{{ $saving->id }}" tabindex="-1"
                aria-labelledby="deleteModalLabel{{ $saving->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('savings.destroy', $saving->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteModalLabel{{ $saving->id }}">
                                    Confirm Deletion
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the saving goal
                                <strong>"{{ $saving->name }}"</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, delete it</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach


        @foreach ($savings as $saving)
            <!-- Show Modal -->
            <div class="modal fade" id="showModal{{ $saving->id }}" tabindex="-1"
                aria-labelledby="showModalLabel{{ $saving->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="showModalLabel{{ $saving->id }}">
                                Saving Details
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Name:</strong> {{ $saving->name }}</li>
                                <li class="list-group-item"><strong>Target Amount:</strong>
                                    {{ number_format($saving->target_amount, 2) }} FCFA</li>
                                <li class="list-group-item"><strong>Current Amount:</strong>
                                    {{ number_format($saving->current_amount, 2) }} FCFA</li>
                                <li class="list-group-item"><strong>Deadline:</strong>
                                    {{ \Carbon\Carbon::parse($saving->deadline)->format('d/m/Y') }}</li>
                                <li class="list-group-item"><strong>Goal:</strong> {{ $saving->goal ?? '—' }}</li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@endsection