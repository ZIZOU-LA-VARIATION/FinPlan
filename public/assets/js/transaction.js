document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    const rowsPerPage = 10;
    const tableRows = Array.from(document.querySelectorAll("#transactionTable tr"));
    const totalPages = Math.ceil(tableRows.length / rowsPerPage);

    function renderPagination() {
        const paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement('li');
            pageItem.className = 'page-item';
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener('click', function () {
                currentPage = i;
                showPage(currentPage);
            });
            paginationContainer.appendChild(pageItem);
        }

        document.getElementById('nextButton').disabled = currentPage === totalPages;
    }

    function showPage(page) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;

        tableRows.forEach((row, index) => {
            row.style.display = index >= startIndex && index < endIndex ? "" : "none";
        });
    }

    document.getElementById('nextButton').addEventListener('click', function () {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    document.getElementById('search').addEventListener('input', function () {
        const searchTerm = this.value.toLowerCase();

        tableRows.forEach(row => {
            const textContent = row.innerText.toLowerCase();
            row.style.display = textContent.includes(searchTerm) ? "" : "none";
        });
    });

    renderPagination();
    showPage(currentPage);

    
});

document.addEventListener('DOMContentLoaded', function () {
    const openModalButton = document.getElementById('openModalButton');
    const modalElement = document.getElementById('transactionModal');
    const modalInstance = new bootstrap.Modal(modalElement);
    
    const saveTransactionButton = document.getElementById('saveTransactionButton');
    const transactionForm = document.getElementById('transactionForm');
    const transactionTable = document.getElementById('transactionTable').getElementsByTagName('tbody')[0];

    let transactionCount = 1;  // For numbering the transactions

    // Récupère le bouton d'ouverture du modal
    openModalButton.addEventListener('click', function () {
        modalInstance.show();  // Affiche le modal
    });

});



