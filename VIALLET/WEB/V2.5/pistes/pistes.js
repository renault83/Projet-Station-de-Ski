async function chargerPistes() {
    try {
        const response = await fetch('pistes_live.php');
        const data = await response.json();

        let html = '';
        data.forEach(p => {
            let diffClass = '';
            const diff = p.difficulte.toLowerCase();
            if(diff === 'verte') diffClass = 'diff-verte';
            else if(diff === 'bleue') diffClass = 'diff-bleue';
            else if(diff === 'rouge') diffClass = 'diff-rouge';
            else if(diff === 'noire') diffClass = 'diff-noire';

            html += `
            <tr>
                <td>${p.nom}</td>
                <td><span class="badge ${diffClass}">${p.difficulte.charAt(0).toUpperCase() + p.difficulte.slice(1)}</span></td>
                <td><span class="${p.etat==='ouvert' ? 'status-ouvert' : 'status-ferme'}">
                    ${p.etat==='ouvert' ? 'Ouverte' : 'Fermée'}
                </span></td>
            </tr>`;
        });

        document.getElementById('pistes-body').innerHTML = html;
    } catch (error) {
        console.error('Erreur lors du chargement des pistes:', error);
    }
}

/* Chargement initial */
chargerPistes();

/* Actualisation toutes les 10 secondes */
setInterval(chargerPistes, 10000);