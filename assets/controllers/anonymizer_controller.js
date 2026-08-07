import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        entite: String,
        champ: String,
        casPvId: Number
    }

    connect() {
        // Récupérer le texte depuis la div
        const targetDiv = this.element;
        const currentText = targetDiv.textContent || targetDiv.innerText;
        
        // Si le texte est vide, pas besoin de continuer
        if (!currentText.trim()) {
            return;
        }

        // Appeler l'API pour obtenir les données d'anonymisation
        this.fetchAnonymizedData()
            .then(data => {
                if (data && data.length > 0) {
                    // Appliquer le surlignage
                    this.applyHighlightingToDiv(targetDiv, data);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données d\'anonymisation:', error);
            });
    }

    async fetchAnonymizedData() {
        const url = `/api/anonymizer/${this.entiteValue}/${this.champValue}/${this.casPvIdValue}`;
        
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            return data.data || [];
        } catch (error) {
            console.error('Erreur de requête API:', error);
            return [];
        }
    }

    applyHighlightingToDiv(targetDiv, data) {
        // Créer un conteneur pour afficher le texte avec surlignage
        const container = document.createElement('div');
        container.className = 'anonymizer-container';
        
        // Utiliser le texte complet du div
        const originalText = targetDiv.textContent || targetDiv.innerText;
        let displayText = originalText;
        
        // Si on a des données avec texteComplet, on l'utilise comme base
        if (data.length > 0 && data[0].texteComplet) {
            displayText = data[0].texteComplet;
        }
        
        // Appliquer le surlignage sur le texte complet
        const highlightedText = this.highlightText(displayText, data);
        container.innerHTML = highlightedText;
        
        // Remplacer le contenu de la div par le texte surligné
        targetDiv.parentNode.replaceChild(container, targetDiv);
    }

    highlightText(text, data) {
        let result = text;
        
        // Tri des données par longueur décroissante pour éviter les conflits
        const sortedData = [...data].sort((a, b) => (b.textAAnonymiser?.length || 0) - (a.textAAnonymiser?.length || 0));
        
        // Appliquer le surlignage pour chaque chaîne à anonymiser
        sortedData.forEach(item => {
            if (item.textAAnonymiser && item.textAAnonymiser.trim()) {
                // Échapper les caractères spéciaux pour l'expression régulière
                const escapedString = item.textAAnonymiser.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                
                // Créer une expression régulière insensible à la casse
                const regex = new RegExp(`(${escapedString})`, 'gi');
                
                // Remplacer par la version surlignée
                result = result.replace(regex, '<span class="anonymized-string">$1</span>');
            }
        });
        
        return result;
    }
}