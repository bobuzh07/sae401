import React, { useEffect, useRef } from 'react';
import Chart from 'chart.js/auto';

export default function Page2({ search = "" }) {
  const chartRef = useRef(null);      // Référence au <canvas>
  const chartInstance = useRef(null); // Stocke l'instance pour la détruire si besoin

  useEffect(() => {
    const texteRecherche = search.toLowerCase().trim();

    // --- FONCTION POUR GÉNÉRER LE GRAPHIQUE ---
    const dessinerCamembert = (labels, valeurs, couleurs) => {
      // On détruit l'ancien graphique pour éviter les superpositions au survol
      if (chartInstance.current) chartInstance.current.destroy();
      if (!chartRef.current) return;

      chartInstance.current = new Chart(chartRef.current, {
        type: 'pie', // Type Camembert
        data: {
          labels: labels,
          datasets: [{ 
            data: valeurs, 
            backgroundColor: couleurs,
            borderWidth: 0 // Supprime les bordures blanches pour un look plus moderne
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { 
              position: 'bottom', // Légende en bas
              labels: { color: 'white', padding: 20 } 
            }
          }
        }
      });
    };

    // 1. ÉTAT INITIAL : Si pas de recherche, on affiche un cercle gris neutre
    if (!texteRecherche) {
      dessinerCamembert(["En attente..."], [1], ["#333"]);
      return; 
    }

    // 2. RÉCUPÉRATION DES DONNÉES
    fetch('http://127.0.0.1:8000/api/departements')
      .then(res => res.json())
      .then(data => {
        // On cherche le département correspondant à la recherche
        const target = data.find(v => 
          v.nom_departement.toLowerCase().includes(texteRecherche) || 
          v.code_departement.toString().includes(texteRecherche)
        );

        if (target && target.statistiques?.[0]) {
          const stats = target.statistiques[0];
          
          // Préparation des chiffres
          const m20 = parseFloat(stats.moins_20ans) || 0;
          const p60 = parseFloat(stats.plus_60ans) || 0;
          const autre = 100 - m20 - p60; // Le reste de la population

          // Affichage du graphique avec les vraies données
          dessinerCamembert(
            [`-20 ans (${m20}%)`, `+60 ans (${p60}%)`, `Autres (${autre.toFixed(1)}%)`],
            [m20, p60, autre],
            ['#3498db', '#e74c3c', '#2ecc71'] // Bleu, Rouge, Vert
          );
        }
      })
      .catch(err => console.error("Erreur API Page 2 :", err));

    // NETTOYAGE : Détruit le graph quand le composant est retiré de l'écran
    return () => { if (chartInstance.current) chartInstance.current.destroy(); };
  }, [search]); // Se relance quand la recherche change

  return (
    <div style={{ height: "300px", width: "100%", padding: "10px" }}>
      <canvas ref={chartRef}></canvas>
    </div>
  );
}