// 
document.addEventListener('DOMContentLoaded', function () {
    // Sample dynamic data
    const data = {
        totalBalance: 500000,
        monthlyExpenses: 120000,
        income: 200000,
        savingsGoal: 200000,
        savingsCurrent: 50000,
        transactions: [20000, 50000, 40000, 60000, 30000, 70000],
        categories: {
            "Housing": 30,
            "Food": 25,
            "Transport": 15,
            "Leisure": 20,
            "Others": 10
        },
        incomeCategories: {
            "Salary": 70,
            "Freelance": 20,
            "Investments": 10
        }
    };

    // Update the display
    document.getElementById('total-balance').innerText = data.totalBalance.toLocaleString() + " XOF";
    document.getElementById('monthly-expenses').innerText = data.monthlyExpenses.toLocaleString() + " XOF";
    document.getElementById('income').innerText = data.income.toLocaleString() + " XOF";
    document.getElementById('savings-goal').innerText = data.savingsGoal.toLocaleString() + " XOF";

    // Update the savings progress bar
    let progress = (data.savingsCurrent / data.savingsGoal) * 100;
    document.getElementById('savings-progress').style.width = progress + "%";

    // Graphique des transactions à barres groupées (Entrées vs Sorties)
    new Chart(document.getElementById("transactionsChart"), {
        type: 'bar', // Utilisation d'un graphique à barres
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"], // Mois
            datasets: [{
                label: 'Entrées',
                data: [20000, 50000, 40000, 60000, 30000, 70000], // Montants des entrées pour chaque mois
                backgroundColor: "#36a2eb", // Couleur des barres des Entrées
                borderColor: "#36a2eb", // Bordure des barres
                borderWidth: 1
            },
            {
                label: 'Sorties',
                data: [15000, 30000, 25000, 40000, 20000, 60000], // Montants des sorties pour chaque mois
                backgroundColor: "#ff6384", // Couleur des barres des Sorties
                borderColor: "#ff6384", // Bordure des barres
                borderWidth: 1
            }
            ]
        },
        options: {
            responsive: true, // Rendre le graphique responsive
            scales: {
                x: {
                    beginAtZero: true // Commencer l'axe X à zéro
                },
                y: {
                    beginAtZero: true, // Commencer l'axe Y à zéro
                    ticks: {
                        stepSize: 10000 // Intervalle des valeurs sur l'axe Y
                    }
                }
            }
        }
    });

    // Expenses by category chart
    new Chart(document.getElementById("categoriesChart"), {
        type: 'doughnut',
        data: {
            labels: Object.keys(data.categories),
            datasets: [{
                data: Object.values(data.categories),
                backgroundColor: ["#ff6384", "#36a2eb", "#ffcd56", "#4bc0c0", "#9966ff"]
            }]
        }
    });

    // Income by category chart (new addition)
    new Chart(document.getElementById("incomeChart"), {
        type: 'pie',
        data: {
            labels: Object.keys(data.incomeCategories),
            datasets: [{
                data: Object.values(data.incomeCategories),
                backgroundColor: ["#ff9f40", "#ffcd56", "#36a2eb"]
            }]
        }
    });

    // Logout button functionality
    document.getElementById('logout-btn').addEventListener('click', function () {
        alert("Logout successful!");
        window.location.href = "index.html"; // Redirect to the login page
    });
});
