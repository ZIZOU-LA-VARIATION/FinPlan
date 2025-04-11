@foreach ($transactions as $transaction)

    <!-- Modal pour l'édition d'une transaction -->
    <div class="modal fade" id="editTransactionModal{{ $transaction->id }}" tabindex="-1"
        aria-labelledby="editTransactionModalLabel{{ $transaction->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="editTransactionModalLabel{{ $transaction->id }}">Edit Transaction</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Sélection de l'activité -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="activity_id" name="activity_id" required>
                                @foreach ($activities as $activity)
                                    <option value="{{ $activity->id }}" {{ $transaction->id_activity == $activity->id ? 'selected' : '' }}>
                                        {{ $activity->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="activity_id">Activity</label>
                        </div>

                        <!-- Sélection du compte bancaire -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="account_id" name="account_id" required>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->id }}" {{ $transaction->id_account == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="account_id">Bank Account</label>
                        </div>

                        <!-- Date -->
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="date" name="date"
                                value="{{ $transaction->date->format('Y-m-d') }}" required>
                            <label for="date">Date</label>
                        </div>

                        <!-- Montant -->
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01"
                                value="{{ $transaction->amount }}" required>
                            <label for="amount">Amount</label>
                        </div>

                        <!-- Type -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="type" name="type" required>
                                <option value="income" {{ $transaction->type == 'income' ? 'selected' : '' }}>Income</option>
                                <option value="expense" {{ $transaction->type == 'expense' ? 'selected' : '' }}>Expense
                                </option>
                            </select>
                            <label for="type">Transaction Type</label>
                        </div>

                        <!-- Description -->
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" name="description"
                                style="height: 100px">{{ $transaction->description }}</textarea>
                            <label for="description">Description</label>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100">Update Transaction</button>
                        <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach