import React, { useEffect, useRef } from 'react';
import Chart from 'chart.js/auto';

export default function Page1({ search = "" }) { 
  const chartRef = useRef(null);      // Référence vers l'élément <canvas> HTML
  const chartInstance = useRef(null); // Stocke l'instance du graphique pour pouvoir le détruire

  useEffect(() => {
    // 1. Délai pour éviter de harceler l'API à chaque lettre tapée (Debounce)
    const timer = setTimeout(() => {
      fetch('http://127.0.0.1:8000/api/departements')
        .then(res => res.json())
        .then(data => {
          const s = search.toLowerCase().trim();

          // 2. Filtrage des départements selon la recherche
          const filtered = data.filter(v => 
            v.nom_departement.toLowerCase().includes(s) || 
            v.code_departement.toString().includes(s)
          ).slice(0, 5); // On ne garde que les 5 premiers

          // 3. Nettoyage : Si un graphique existe déjà, on le supprime avant d'en créer un nouveau
          if (chartInstance.current) chartInstance.current.destroy();

          // 4. Création du graphique si on a des données
          if (chartRef.current && filtered.length > 0) {
            chartInstance.current = new Chart(chartRef.current, {
              type: 'bar',
              data: {
                // Création des étiquettes (Labels)
                labels: filtered.map(v => {
                  const stats = v.statistiques.find(st => st.annee === 2023) || v.statistiques[0];
                  return [v.nom_departement, (stats?.nb_habitant || 0).toLocaleString() + " hab."];
                }),
                datasets: [{
                  label: 'Nombre d\'habitants',
                  data: filtered.map(v => {
                    const stats = v.statistiques.find(st => st.annee === 2023) || v.statistiques[0];
                    return stats?.nb_habitant || 0;
                  }),
                  backgroundColor: 'rgba(155, 89, 182, 0.8)',
                  borderColor: '#9b59b6',
                  borderWidth: 1
                }]
              },
              options: { 
                responsive: true,
                maintainAspectRatio: false, // Permet au graph de s'adapter à la taille de la Card
                scales: {
                  y: { 
                    beginAtZero: true, 
                    ticks: { color: 'white' }, // Chiffres en blanc
                    grid: { color: 'rgba(255, 255, 255, 0.1)' } // Lignes de grille discrètes
                  },
                  x: { 
                    ticks: { color: 'white', font: { size: 11, weight: 'bold' } },
                    grid: { display: false } // On cache la grille verticale pour plus de clarté
                  }
                },
                plugins: {
                  legend: { labels: { color: 'white' } } // Texte de légende en blanc
                }
              }
            });
          }
        })
        .catch(err => console.error("Erreur API:", err));
    }, 300);

    // 5. Nettoyage final quand on quitte la page ou change de recherche
    return () => {
      clearTimeout(timer);
      if (chartInstance.current) chartInstance.current.destroy();
    };
  }, [search]); // Le code se relance dès que la variable "search" change

  return (
    <div style={{ height: '100%', width: '100%' }}>
      <canvas ref={chartRef}></canvas>
    </div>
  );
}