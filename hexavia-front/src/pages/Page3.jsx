import React, { useEffect, useRef } from 'react';
import Chart from 'chart.js/auto';

export default function Page3({ search = "" }) {
  const chartRef = useRef(null);
  const chartInstance = useRef(null);

  useEffect(() => {
    const s = search.toLowerCase().trim();

    const renderLine = (label = "En attente", labels = ["-"], dataPoints = [0]) => {
      if (chartInstance.current) chartInstance.current.destroy();
      if (!chartRef.current) return;

      chartInstance.current = new Chart(chartRef.current, {
        type: 'line',
        data: {
          labels: labels,
          datasets: [{
            label: label,
            data: dataPoints,
            borderColor: '#f1c40f',
            backgroundColor: 'rgba(241, 196, 15, 0.1)',
            fill: true,
            tension: 0.3
          }]
        },
        options: { 
          responsive: true, 
          maintainAspectRatio: false,
          scales: {
            y: { min: 0, max: 100, ticks: { color: 'white' } },
            x: { ticks: { color: 'white', maxRotation: 0 } }
          },
          plugins: { legend: { labels: { color: 'white' } } }
        }
      });
    };

    if (!s) {
      renderLine("Taux de Pauvreté %", ["2020", "2021", "2022", "2023"], [0, 0, 0, 0]);
      return;
    }

    const timer = setTimeout(() => {
      fetch('http://127.0.0.1:8000/api/stats')
        .then(res => res.json())
        .then(data => {
          const filtered = data
            .filter(v => v.nom_departement.toLowerCase().includes(s) || v.code_departement.toString().includes(s))
            .sort((a, b) => parseInt(a.annee) - parseInt(b.annee));

          if (filtered.length > 0) {
            const pauvreKey = Object.keys(filtered[0]).find(k => k.toLowerCase().includes("pauvr"));
            renderLine(
              `Pauvreté - ${filtered[0].nom_departement}`,
              filtered.map(d => d.annee),
              filtered.map(d => parseFloat(d[pauvreKey]) || 0)
            );
          }
        });
    }, 400);

    return () => {
      clearTimeout(timer);
      if (chartInstance.current) chartInstance.current.destroy();
    };
  }, [search]);

  return (
    <div style={{ position: 'relative', height: '250px', width: '100%' }}>
      <canvas ref={chartRef}></canvas>
    </div>
  );
}