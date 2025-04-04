@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-5">
            <div class="aligne">
                <div>
                    <img src="{{asset('assets/img/account.png')}}" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Bank Accounts</span>
                </h2>
            </div>

            <div class="transaction-header mb-3">

                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#accountModal">
                    <i class="fas fa-plus"></i> Add Account
                </button>

                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search account...">

            </div>


            <!-- Tableau des comptes -->
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Bank Name</th>
                                <th>Type</th>
                                <th>Initial Balance</th>
                                <th>Current Balance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="Table">
                            <tr>
                                <td>1</td>
                                <td>Bank of America</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+5,000 FCFA</td>
                                <td class="text-danger fw-bold">-4,500 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Chase</td>
                                <td><span class="badge bg-success">Savings</span></td>
                                <td class="text-success fw-bold">+2,000 FCFA</td>
                                <td class="text-success fw-bold">+2,300 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wells Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
                                <td>
                                    <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Wellxx Fargo</td>
                                <td><span class="badge bg-primary">Checking</span></td>
                                <td class="text-success fw-bold">+3,000 FCFA</td>
                                <td class="text-danger fw-bold">-2,700 FCFA</td>
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

        <div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accountModalLabel">Add Bank Account</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="bankName" class="form-label">Bank Name</label>
                                <input type="text" class="form-control" id="bankName" required>
                            </div>
                            <div class="mb-3">
                                <label for="accountType" class="form-label">Account Type</label>
                                <select class="form-control" id="accountType">
                                    <option>Checking</option>
                                    <option>Savings</option>
                                </select>
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