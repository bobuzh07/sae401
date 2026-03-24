import React, { useEffect, useRef } from 'react';
import Chart from 'chart.js/auto';

export default function Page4({ search = "" }) {
  const chartRef = useRef(null);
  const chartInstance = useRef(null);

  useEffect(() => {
    const s = search.toLowerCase().trim();

    const renderChart = (label = "En attente", dataValues = [0, 0]) => {
      if (chartInstance.current) chartInstance.current.destroy();
      if (!chartRef.current) return;

      chartInstance.current = new Chart(chartRef.current, {
        type: 'bar',
        data: {
          labels: ['Chômage %', 'Pauvreté %'],
          datasets: [{
            label: label,
            data: dataValues,
            backgroundColor: ['#f1c40f', '#9b59b6'],
            borderRadius: 5
          }]
        },
        options: { 
          responsive: true, 
          maintainAspectRatio: false,
          layout: {
            padding: { top: 10, bottom: 10 } // Petites marges internes pour la propreté
          },
          scales: {
            y: { 
              min: 0, 
              max: 100, 
              ticks: { color: 'white' },
              grid: { color: 'rgba(255, 255, 255, 0.1)' }
            },
            x: { 
              ticks: { color: 'white', font: { weight: 'bold' } },
              grid: { display: false }
            }
          },
          plugins: { 
            legend: { 
              position: 'top',
              labels: { color: 'white' } 
            } 
          }
        }
      });
    };

    if (!s) {
      renderChart("Aucune sélection", [0, 0]);
      return;
    }

    const timer = setTimeout(() => {
      fetch('http://127.0.0.1:8000/api/departements') // Assure-toi que l'URL est correcte
        .then(res => res.json())
        .then(data => {
          const target = data.find(v => 
            v.nom_departement.toLowerCase().includes(s) || 
            v.code_departement.toString().includes(s)
          );

          if (target) {
            // On récupère les stats les plus récentes (ex: 2022 ou 2023)
            const stats = target.statistiques[target.statistiques.length - 1];
            const valC = stats?.taux_chomage || 0;
            const valP = stats?.taux_pauvrete || 0;
            renderChart(target.nom_departement, [valC, valP]);
          } else {
            renderChart("Non trouvé", [0, 0]);
          }
        })
        .catch(err => console.error("Erreur API Page 4:", err));
    }, 400);

    return () => {
      clearTimeout(timer);
      if (chartInstance.current) chartInstance.current.destroy();
    };
  }, [search]);

  return (
    // On occupe 100% de la div de 250px définie dans le Dashboard
    <div style={{ position: 'relative', height: '100%', width: '100%' }}>
      <canvas ref={chartRef}></canvas>
    </div>
  );
}