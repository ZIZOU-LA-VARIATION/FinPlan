@extends('layouts.app')

@section('admin_layout')
<div class="container-fluid py-4">
    <div class="container mt-5">
        <div class="aligne">
            <div>
                <img src="{{asset('assets/img/budget.png')}}" alt="" class="images">
            </div>
            <h2 class="text">
                <span class="text-success mb-4">Budgets</span>
            </h2>
        </div>

        <div class="transaction-header mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#budgetModal">
                <i class="fas fa-plus"></i> Add Budget
            </button>

            <!-- Champ de recherche -->
            <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search budget...">
        </div>

        <!-- Tableau des budgets -->
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Budget Name</th>
                            <th>Category</th>
                            <th>Activitie</th>
                            <th>Amount</th>
                            <th>Start_date</th>
                            <th>End_date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="Table">
                        <tr>
                            <td>1</td>
                            <td>Food Budget</td>
                            <td><span class="badge bg-warning">Food</span></td>
                            <td class="text-success fw-bold">+50,000 FCFA</td>
                            <td class="text-danger fw-bold">-30,000 FCFA</td>
                            <td>2025-01-01</td>
                            <td>2025-12-31</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Transport Budget</td>
                            <td><span class="badge bg-info">Transport</span></td>
                            <td class="text-success fw-bold">+20,000 FCFA</td>
                            <td class="text-success fw-bold">+15,000 FCFA</td>
                            <td>2025-02-01</td>
                            <td>2025-06-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Entertainment Budget</td>
                            <td><span class="badge bg-danger">Entertainment</span></td>
                            <td class="text-success fw-bold">+30,000 FCFA</td>
                            <td class="text-danger fw-bold">-10,000 FCFA</td>
                            <td>2025-03-01</td>
                            <td>2025-09-30</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
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

    <!-- Modal pour ajouter un budget -->
    <div class="modal fade" id="budgetModal" tabindex="-1" aria-labelledby="budgetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="budgetModalLabel">Add Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="budgetName" class="form-label">Budget Name</label>
                            <input type="text" class="form-control" id="budgetName" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category">
                                <option>Food</option>
                                <option>Transport</option>
                                <option>Entertainment</option>
                                <option>Housing</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="allocatedAmount" class="form-label">Allocated Amount</label>
                            <input type="number" class="form-control" id="allocatedAmount" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Budget</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection