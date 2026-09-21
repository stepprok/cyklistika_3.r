document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('sortableTable');
    if (!table) return;

    const headers = table.querySelectorAll('th');
    const tbody = table.querySelector('tbody');

    headers.forEach((header, index) => {
        let asc = true;

        header.addEventListener('click', () => {
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const cellA = a.children[index].innerText.trim();
                const cellB = b.children[index].innerText.trim();

                // Detekce čísla pro správné numerické řazení (např. u ID nebo délky)
                const numA = parseFloat(cellA.replace(',', '.'));
                const numB = parseFloat(cellB.replace(',', '.'));

                if (!isNaN(numA) && !isNaN(numB)) {
                    return asc ? numA - numB : numB - numA;
                }

                // Běžné textové řazení (A-Z / Z-A)
                return asc 
                    ? cellA.localeCompare(cellB, 'cs', { numeric: true }) 
                    : cellB.localeCompare(cellA, 'cs', { numeric: true });
            });

            // Přerovnání řádků v DOMu
            rows.forEach(row => tbody.appendChild(row));

            // Vizuální indikátor směru (šipka u vybraného sloupce)
            headers.forEach(h => h.innerText = h.innerText.replace(/ [▲▼]/, ''));
            header.innerText += asc ? ' ▲' : ' ▼';

            asc = !asc; // Prohození směru pro další kliknutí
        });
    });
});