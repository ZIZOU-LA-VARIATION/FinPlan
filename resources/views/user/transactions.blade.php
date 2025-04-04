@extends('layouts.app')

@section('admin_layout')
    <div class="container-fluid py-4">
        <div class="container mt-4">
            <div class="aligne">
                <div>
                    <img src="../assets/img/transaction.png" alt="" class="images">
                </div>
                <h2 class="text">
                    <span class="text-success mb-4">Transactions</span>
                </h2><br><br><br><br><br>
            </div>


            <div class="transaction-header mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#transactionModal">
                    Voir Transaction
                </button>
                <!-- Champ de recherche -->
                <input type="text" id="search" class="form-control mb-3 w-25" placeholder="Search transaction...">
            </div>
        </div>

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>Account Name</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionTable">
                        <tr>
                            <td>2025-03-27</td>
                            <td><span class="badge bg-success">Income</span></td>
                            <td>Salary</td>
                            <td>Main Account</td>
                            <td>Monthly salary</td>
                            <td class="text-success fw-bold">+50,000 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2025-03-26</td>
                            <td><span class="badge bg-danger">Expense</span></td>
                            <td>Food</td>
                            <td>Credit Card</td>
                            <td>Groceries</td>
                            <td class="text-danger fw-bold">-15,000 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2025-03-25</td>
                            <td><span class="badge bg-success">Income</span></td>
                            <td>Freelance</td>
                            <td>PayPal</td>
                            <td>Freelance project</td>
                            <td class="text-success fw-bold">+20,000 FCFA</td>
                            <td>
                                <button class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center align-items-center">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination"></ul>
                    </nav>
                    <button class="btn btn-primary" id="nextButton">Next</button>
                </div>
            </div>
        </div>

        <!-- Le Modal -->
        <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionModalLabel">Add Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulaire de transaction -->
                        <form id="transactionForm">
                            <div class="mb-3">
                                <label for="transactionAmount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="transactionAmount" placeholder="Enter amount"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="transactionType" class="form-label">Type</label>
                                <select class="form-control" id="transactionType" required>
                                    <option value="deposit">Deposit</option>
                                    <option value="withdrawal">Withdrawal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="transactionDescription" class="form-label">Description</label>
                                <input type="text" class="form-control" id="transactionDescription"
                                    placeholder="Enter description" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveTransactionButton">Save Transaction</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('assets/js/transaction.js')}}"></script>
@endsection