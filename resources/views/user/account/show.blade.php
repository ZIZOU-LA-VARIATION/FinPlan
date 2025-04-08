@extends('layouts.app')

@section('admin_layout')

    <div class="container-fluid py-4">
        <div class="container mt-5">

            <div class="card-header">
                Détails du Compte {{ $account->name }}
            </div>

            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-hover table-bordered">

                        <thead class="table-dark">
                            <tr>
                                <th>Attributs</th>
                                <th>Value</th>
                            </tr>
                        </thead>

                        <tbody id="Table">
                            <tr>
                                <td>Name</td>
                                <td>{{ $account->name }}</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td>{{ $account->bank_name }}</td>
                            </tr>
                            <tr>
                                <td>Type</td>
                                <td><span class="badge bg-primary">{{ $account->account_type }}</span></td>
                            </tr>
                            <tr>
                                <td>Initial Balance</td>
                                <td class="text-success fw-bold">{{ $account->initial_balance }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div><br>
            </div>
        </div>
    </div>
    <a href="{{ route('accounts.index') }}" class="btn btn-primary">Retour à la liste</a>
@endsection

@section('script')
    <script src="{{asset('assets/js/table.js')}}"></script>
@endsection