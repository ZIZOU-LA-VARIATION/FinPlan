@extends('layouts.app')

@section('admin_layout')
<div class="container-fluid py-4">
    <div class="container mt-5">
        <div class="aligne">
            <div>
                <img src="{{asset('assets/img/saving.png')}}" alt="" class="images">
            </div>
            <h2 class="text">
                <span class="text-success mb-4">Invioces</span>
            </h2>
        </div>

        <div class="transaction-header mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#savingsModal">
                <i class="fas fa-plus"></i> Add Invioce
            </button>
            <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search invioce...">
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Activitie</th>
                            <th>Amount</th>
                            <th>deadline</th>
                            <th>status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="Table">
                        <tr>
                            <td>1</td>
                            <td>Bank of America</td>
                            <td><span class="badge bg-success">Savings</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americadcvbg</td>
                            <td><span class="badge bg-success">Savings</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of America</td>
                            <td><span class="badge bg-success">Savingshjc</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of America</td>
                            <td><span class="badge bg-success">Savingsvbn</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Bank of Americaa</td>
                            <td><span class="badge bg-success">Savingsqdf</span></td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+10,000 FCFA</td>
                            <td class="text-success fw-bold">+12,500 FCFA</td>
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

    <div class="modal fade" id="savingsModal" tabindex="-1" aria-labelledby="savingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="savingsModalLabel">Add Savings Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="bankName" class="form-label">Bank Name</label>
                            <input type="text" class="form-control" id="bankName" required>
                        </div>
                        <div class="mb-3">
                            <label for="initialBalance" class="form-label">Initial Balance</label>
                            <input type="number" class="form-control" id="initialBalance" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Account</button>
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