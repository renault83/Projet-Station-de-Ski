async function refreshAlerte() {
    try {
        const res = await fetch('page_accueil/alerte.php', { cache: 'no-store' });
        const data = await res.json();

        const box = document.getElementById('alerte-box');
        const niveau = document.getElementById('alerte-niveau');
        const message = document.getElementById('alerte-message');

        if (!box || !niveau || !message || !data) return;

        switch(data.niveau) {
            case '0':
                niveau.textContent = '0 — Aucune alerte';
                box.className = 'alert-card alert-0';
                break;
            case '1':
                niveau.textContent = '1 — Vigilance légère';
                box.className = 'alert-card alert-1';
                break;
            case '2':
                niveau.textContent = '2 — Vigilance modérée';
                box.className = 'alert-card alert-2';
                break;
            case '3':
                niveau.textContent = '3 — Alerte maximale';
                box.className = 'alert-card alert-3';
                break;
        }

        message.textContent = data.message;

    } catch (e) {
        console.error('Erreur alerte', e);
    }
}

// Mise à jour toutes les 2 secondes
setInterval(refreshAlerte, 2000);

// Charger immédiatement au chargement
refreshAlerte();
