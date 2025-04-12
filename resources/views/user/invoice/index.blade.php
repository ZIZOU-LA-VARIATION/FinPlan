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
                    <img src="{{asset('assets/img/invoice.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Invioces</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">
                <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Invoice
                </button>

                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search invioce...">
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                @if($invoices->isEmpty())
                    <div class="alert alert-warning">
                        <i class="bi bi-info-circle-fill me-2"></i> No invoice found.
                    </div>
                @else
                    <div class="table-responsive p-0">
                        <table class="table table-hover table-bordered">
                            <thead class="table-info">
                                <tr>
                                    <th>Activity</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="Table">
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <!-- Nom de l'activité -->
                                        <td>{{ $invoice->activity->name ?? 'N/A' }}</td>

                                        <!-- Titre de la facture -->
                                        <td>{{ $invoice->title }}</td>

                                        <!-- Montant -->
                                        <td><span class="badge bg-primary">{{ number_format($invoice->amount, 2) }} FCFA</span></td>

                                        <!-- Date d'échéance -->
                                        <td>{{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</td>

                                        <!-- Statut -->
                                        <td>
                                            <span class="badge 
                                                                    @if($invoice->status == 'unpaid') bg-warning 
                                                                    @elseif($invoice->status == 'paid') bg-success 
                                                                    @endif">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>

                                        <!-- Description -->
                                        <td>
                                            @if (!empty($invoice->description))
                                                {{ $invoice->description }}
                                            @else
                                                <span class="badge bg-secondary">No description</span>
                                            @endif
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editInvoiceModal{{ $invoice->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteInvoiceModal{{ $invoice->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#showInvoiceModal{{ $invoice->id }}">
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

        <!-- Modal pour la création d’une facture -->
        <div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-labelledby="createInvoiceModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('invoices.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createInvoiceModalLabel">Create Invoice</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <!-- Titre de la facture -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title') }}" required placeholder="Enter invoice title">
                                <label for="title">Invoice Title</label>
                                @error('title')
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

                            <!-- Date d’échéance -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date" value="{{ old('due_date') }}" required
                                    placeholder="Due date">
                                <label for="due_date">Due Date</label>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="form-floating mb-3">
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                    required>
                                    <option value="" disabled selected>Select a status</option>
                                    <option value="unpaid" {{ old('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <label for="status">Status</label>
                                @error('status')
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
                            <button type="submit" class="btn btn-primary w-100">Create Invoice</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Invoice Modal -->
        @foreach ($invoices as $invoice)
        <div class="modal fade" id="editInvoiceModal{{ $invoice->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content border-0 shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editInvoiceModalLabel{{ $invoice->id }}">Edit Invoice</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="modal-body bg-light">
                            {{-- Activity --}}
                            <div class="form-floating mb-3">
                                <select name="id_activity" id="id_activity{{ $invoice->id }}"
                                    class="form-select @error('id_activity') is-invalid @enderror" required>
                                    <option value="">Select Activity</option>
                                    @foreach ($activities as $activity)
                                        <option value="{{ $activity->id }}"
                                            {{ old('id_activity', $invoice->id_activity) == $activity->id ? 'selected' : '' }}>
                                            {{ $activity->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_activity{{ $invoice->id }}">Activity</label>
                                @error('id_activity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Title --}}
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title{{ $invoice->id }}" name="title"
                                    value="{{ old('title', $invoice->title) }}" required
                                    placeholder="Enter title">
                                <label for="title{{ $invoice->id }}">Invoice Title</label>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Amount --}}
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                    id="amount{{ $invoice->id }}" name="amount"
                                    value="{{ old('amount', $invoice->amount) }}" required step="0.01"
                                    placeholder="Enter amount">
                                <label for="amount{{ $invoice->id }}">Amount</label>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Due Date --}}
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                    id="due_date{{ $invoice->id }}" name="due_date"
                                    value="{{ old('due_date', $invoice->due_date) }}" required>
                                <label for="due_date{{ $invoice->id }}">Due Date</label>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status --}}
                            <div class="form-floating mb-3">
                                <select name="status" id="status{{ $invoice->id }}"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="unpaid" {{ old('status', $invoice->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="paid" {{ old('status', $invoice->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                </select>
                                <label for="status{{ $invoice->id }}">Status</label>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    placeholder="Enter description" id="description{{ $invoice->id }}" name="description"
                                    style="height: 100px">{{ old('description', $invoice->description) }}</textarea>
                                <label for="description{{ $invoice->id }}">Description</label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Update Invoice</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal de confirmation de suppression des invoices -->
        @foreach ($invoices as $invoice)

        <div class="modal fade" id="deleteInvoiceModal{{ $invoice->id }}" tabindex="-1"
            aria-labelledby="deleteInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteInvoiceModalLabel{{ $invoice->id }}">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <strong class="text-danger">
                                {{ $invoice->title ?? 'This invoice' }}
                            </strong> will be permanently deleted. Are you sure?
                        </p>
                        <p class="text-muted">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left-circle me-1"></i> Cancel
                        </button>
                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="d-inline">
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

        @foreach ($invoices as $invoice)
        <!-- Modal de détail de la facture -->
        <div class="modal fade" id="showInvoiceModal{{ $invoice->id }}" tabindex="-1"
            aria-labelledby="showInvoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="showInvoiceModalLabel{{ $invoice->id }}">
                            <i class="bi bi-file-earmark-text me-2"></i> Invoice Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
    
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><i class="bi bi-person-circle me-2 text-primary"></i><strong>User:</strong>
                                    {{ $invoice->user->name ?? 'N/A' }}</p>
                                <p><i class="bi bi-briefcase-fill me-2 text-primary"></i><strong>Activity:</strong>
                                    {{ $invoice->activity->name ?? 'N/A' }}</p>
                                <p><i class="bi bi-currency-dollar me-2 text-primary"></i><strong>Amount:</strong>
                                    {{ number_format($invoice->amount, 2) }} FCFA</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="bi bi-calendar-event me-2 text-primary"></i><strong>Start Date:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->start_date)->format('d M Y') }}</p>
                                <p><i class="bi bi-calendar-check me-2 text-primary"></i><strong>End Date:</strong>
                                    {{ \Carbon\Carbon::parse($invoice->end_date)->format('d M Y') }}</p>
                                <p><i class="bi bi-pencil-square me-2 text-primary"></i><strong>Description:</strong>
                                    {{ !empty($invoice->description) ? $invoice->description : 'No description' }}</p>
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