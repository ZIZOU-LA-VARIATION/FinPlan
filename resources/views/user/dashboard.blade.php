
@extends('layouts.admin')
@section('title_admin','Dashboard')

@section('admin_layout')
<div class="container mt-5">
    <h1 class="mb-4">Tableau de bord de l'utilisateur</h1>
    <div class="row">
        <!-- Cartes Statistiques -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Solde actuel</h5>
                    <p class="card-text">1 200 €</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dépenses</h5>
                    <p class="card-text">800 €</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Dettes</h5>
                    <p class="card-text">300 €</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Objectifs d'épargne</h5>
                    <p class="card-text">500 €</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Dernières opérations -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Dernières opérations</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Achat supermarché - 50 €</li>
                        <li class="list-group-item">Paiement loyer - 500 €</li>
                        <li class="list-group-item">Abonnement Netflix - 15 €</li>
                        <li class="list-group-item">Salaire reçu + 1 200 €</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
