async function chargerRemontees() {
    try {
        const response = await fetch('api_remontes.php');
        const data = await response.json();

        const tbody = document.getElementById('remontees-body');
        tbody.innerHTML = '';

        data.forEach(r => {
            let etatHTML = '';
            if (r.etat === 'ouvert') {
                etatHTML = '<strong style="color: green;">Ouverte</strong>';
            } else if (r.etat === 'ferme') {
                etatHTML = '<strong style="color: red;">Fermée</strong>';
            } else {
                etatHTML = '<strong style="color: orange;">Évacuation</strong>';
            }

            tbody.innerHTML += `
                <tr>
                    <td>${r.nom}</td>
                    <td>${r.heure_ouverture}</td>
                    <td>${r.heure_fermeture}</td>
                    <td>${etatHTML}</td>
                </tr>
            `;
        });
    } catch (error) {
        console.error('Erreur lors du chargement des remontées:', error);
    }
}

/* Chargement initial */
chargerRemontees();

/* Actualisation toutes les secondes */
setInterval(chargerRemontees, 1000);