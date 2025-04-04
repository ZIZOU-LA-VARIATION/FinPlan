document.addEventListener("DOMContentLoaded", function () {
    let currentPage = 1;
    const rowsPerPage = 5;
    const tableBody = document.getElementById("Table");
    const rows = tableBody.getElementsByTagName("tr");
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    const paginationContainer = document.getElementById("pagination");

    // Fonction pour afficher la table en fonction de la page actuelle
    function displayTable(page) {
        // Masquer toutes les lignes
        for (let i = 0; i < rows.length; i++) {
            rows[i].style.display = "none";
        }

        let start = (page - 1) * rowsPerPage;
        let end = start + rowsPerPage;

        // Afficher les lignes de la page courante
        for (let i = start; i < end && i < rows.length; i++) {
            rows[i].style.display = "table-row";
        }

        // Désactiver ou activer les boutons selon la page
        updatePaginationButtons();
    }

    // Fonction pour gérer l'activation/désactivation des boutons Previous et Next
    function updatePaginationButtons() {
        // Désactiver le bouton "Previous" si on est sur la première page
        document.getElementById("prevButton").disabled = currentPage === 1;

        // Désactiver le bouton "Next" si on est sur la dernière page
        document.getElementById("nextButton").disabled = currentPage === totalPages;
    }

    // Fonction pour générer la pagination dynamique
    function renderPagination() {
        paginationContainer.innerHTML = "";
        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement("li");
            pageItem.className = "page-item";
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener("click", function () {
                currentPage = i;
                displayTable(currentPage);
            });
            paginationContainer.appendChild(pageItem);
        }
    }

    // Événements pour les boutons de navigation
    document.getElementById("nextButton").addEventListener("click", function () {
        if (currentPage < totalPages) {
            currentPage++;
            displayTable(currentPage);
        }
    });

    document.getElementById("prevButton").addEventListener("click", function () {
        if (currentPage > 1) {
            currentPage--;
            displayTable(currentPage);
        }
    });

    // Fonction de recherche (si nécessaire)
    document.getElementById("search").addEventListener("input", function () {
        const searchTerm = this.value.toLowerCase();
        for (let row of rows) {
            let bankName = row.cells[1].textContent.toLowerCase();
            row.style.display = bankName.includes(searchTerm) ? "table-row" : "none";
        }
    });

    // Initialiser l'affichage de la table et la pagination
    displayTable(currentPage);
    renderPagination();
});
