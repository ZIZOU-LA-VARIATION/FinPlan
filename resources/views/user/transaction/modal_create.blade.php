        <!-- Modal pour la création d'une transaction -->
        <div class="modal fade" id="createTransactionModal" tabindex="-1" aria-labelledby="createTransactionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('transactions.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="createTransactionModalLabel">Create Transaction</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">

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

                            <!-- Date -->
                            <div class="form-floating mb-3">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                    name="date" value="{{ old('date') }}" required placeholder="Enter date">
                                <label for="date">Date</label>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div class="form-floating mb-3">
                                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror"
                                    required>
                                    <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income</option>
                                    <option value="expense" {{ old('type') == 'expense' ? 'selected' : '' }}>Expense</option>
                                </select>
                                <label for="type">Type</label>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Activité -->
                            <div class="form-floating mb-3">
                                <select name="id_activity" id="id_activity"
                                    class="form-select @error('id_activity') is-invalid @enderror" required>
                                    <option value="" disabled selected>Choose activity</option>
                                    @foreach($activities as $activity)
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

                            <!-- Compte bancaire -->
                            <div class="form-floating mb-3">
                                <select name="id_account" id="id_account"
                                    class="form-select @error('id_account') is-invalid @enderror" required>
                                    <option value="" disabled selected>Choose account</option>
                                    @foreach($accounts as $account)
                                        <option value="{{ $account->id }}" {{ old('id_account') == $account->id ? 'selected' : '' }}>
                                        {{ $account->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="id_account">Bank Account</label>
                                @error('id_account')
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
                            <button type="submit" class="btn btn-primary w-100">Create Transaction</button>
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>