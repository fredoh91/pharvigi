import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        entite: String,
        champ: String,
        casPvId: Number,
        baseUrl: String
    }

    connect() {
        // Récupérer le texte depuis la div
        const targetDiv = this.element;
        const currentText = targetDiv.textContent || targetDiv.innerText;
        // Si le texte est vide, pas besoin de continuer
        if (!currentText.trim()) {
            return;
        }

        // console.log('Texte actuel dans la div:', currentText);
        // Appeler l'API pour obtenir les données d'anonymisation
        this.fetchAnonymizedData()
            .then(data => {
                if (data && data.length > 0) {
                    // Appliquer le surlignage
                    console.log('Données d\'anonymisation reçues:', data);
                    this.applyHighlightingToDiv(targetDiv, data);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des données d\'anonymisation:', error);
            });
    }

    async fetchAnonymizedData() {

        const baseUrl = this.baseUrlValue || '';
        const url = `${baseUrl}/api/anonymizer/${this.entiteValue}/${this.champValue}/${this.casPvIdValue}`;
        
        // const url = `/api/anonymizer/${this.entiteValue}/${this.champValue}/${this.casPvIdValue}`;
        console.log('Récupération des données depuis l\'URL:', url);
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            console.log('Données récupérées:', data);
            return data.data || [];
        } catch (error) {
            console.error('Erreur de requête API:', error);
            return [];
        }
    }
    applyHighlightingToDiv(targetDiv, data) {
        const contentDiv = targetDiv.querySelector('.problematique-content') || targetDiv;
        
        let displayText = contentDiv.textContent || contentDiv.innerText;
        
        if (data.length > 0 && data[0].texteComplet) {
            displayText = data[0].texteComplet;
        }
        
        contentDiv.classList.add('anonymizer-text');
        contentDiv.innerHTML = this.highlightText(displayText, data);
    }

    highlightText(text, data) {
        // Échapper le HTML d'origine pour éviter l'injection et les problèmes de rendu
        let result = text
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
        
        // Tri des données par longueur décroissante pour éviter les sous-remplacements
        const sortedData = [...data].sort((a, b) => (b.textAAnonymiser?.length || 0) - (a.textAAnonymiser?.length || 0));
        
        // Appliquer le surlignage pour chaque chaîne à anonymiser
        sortedData.forEach(item => {
            if (item.textAAnonymiser && item.textAAnonymiser.trim()) {
                // Échapper les caractères spéciaux pour l'expression régulière
                const escapedString = item.textAAnonymiser
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                
                const regex = new RegExp(`(${escapedString})`, 'gi');
                result = result.replace(regex, '<span class="anonymized-string">$1</span>');
            }
        });
        
        // Convertir les sauts de ligne en <br>
        return result.replace(/\n/g, '<br>');
    }

}