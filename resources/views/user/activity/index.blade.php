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
                    <img src="{{asset('assets/img/lifestyle.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Activities</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <!-- Bouton pour ouvrir le modal de création d'une activité -->
                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal"
                    data-bs-target="#createActivityModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Activity
                </button>

                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search invioce...">
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @if($activities->isEmpty())
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle-fill me-2"></i> No activities found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>#ID</th>
                                    <th>Activity Name</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="Table">
                                @foreach ($activities as $activity)
                                    <tr>
                                        <td>{{ $activity->id }}</td>
                                        <td>{{ $activity->name }}</td>
                                        <td>{{ $activity->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <!-- Show -->
                                            <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal"
                                                data-bs-target="#showActivityModal{{ $activity->id }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>

                                            <!-- Edit -->
                                            <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                                data-bs-target="#editActivityModal{{ $activity->id }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>

                                            <!-- Delete -->
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteActivityModal{{ $activity->id }}">
                                                <i class="bi bi-trash-fill"></i>
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

        <!-- Modal pour la création d'une activité -->
        <div class="modal fade" id="createActivityModal" tabindex="-1" aria-labelledby="createActivityModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('activities.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createActivityModalLabel">Create Activity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Nom de l'activité -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" required placeholder="Enter activity name">
                                <label for="name">Activity Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Create Activity</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        {{-- suression --}}
        @foreach ($activities as $activity)
            <div class="modal fade" id="deleteActivityModal{{ $activity->id }}" tabindex="-1"
                aria-labelledby="deleteActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('activities.destroy', $activity->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title" id="deleteActivityModalLabel{{ $activity->id }}">Delete Activity</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the activity <strong>{{ $activity->name }}</strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-danger w-100">Yes, Delete</button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach


        {{-- show --}}
        @foreach ($activities as $activity)
            <div class="modal fade" id="showActivityModal{{ $activity->id }}" tabindex="-1"
                aria-labelledby="showActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title" id="showActivityModalLabel{{ $activity->id }}">
                                <i class="bi bi-eye me-2"></i>Activity Details
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID:</strong> {{ $activity->id }}</p>
                            <p><strong>Name:</strong> {{ $activity->name }}</p>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


        {{-- edit --}}
        @foreach ($activities as $activity)
            <div class="modal fade" id="editActivityModal{{ $activity->id }}" tabindex="-1"
                aria-labelledby="editActivityModalLabel{{ $activity->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" action="{{ route('activities.update', $activity->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editActivityModalLabel{{ $activity->id }}">Edit Activity</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name{{ $activity->id }}" name="name" value="{{ old('name', $activity->name) }}"
                                        required>
                                    <label for="name{{ $activity->id }}">Activity Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning w-100">Update</button>
                                <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach



    </div>

@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection