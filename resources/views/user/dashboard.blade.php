<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - FinPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">
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

        <!-- Graphiques -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Répartition des dépenses</h5>
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Évolution des dépenses mensuelles</h5>
                        <canvas id="lineChart"></canvas>
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

    <!-- Scripts Chart.js -->
    <script>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Logement', 'Courses', 'Loisirs', 'Transport', 'Autres'],
                datasets: [{
                    data: [400, 200, 100, 150, 50],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#9C27B0']
                }]
            }
        });

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Dépenses mensuelles',
                    data: [600, 700, 650, 800, 750, 900],
                    borderColor: '#FF6384',
                    fill: false
                }]
            }
        });
    </script>
</body>
</html>