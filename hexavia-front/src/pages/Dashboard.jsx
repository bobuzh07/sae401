import React, { useState } from "react";
import Card from "../components/Card";
import Filters from "../components/Filters";
import Page1 from "./Page1";
import Page2 from "./Page2";
import Page3 from "./Page3";
import Page4 from "./Page4";

export default function Dashboard() {
  // État pour stocker la valeur de recherche partagée entre tous les graphiques
  const [search, setSearch] = useState("");

  // Style commun pour les conteneurs de cartes afin d'éviter la répétition
  const cardStyle = {
    backgroundColor: '#1a1a1a',
    borderRadius: '15px',
    overflow: 'hidden'
  };

  return (
    <div style={{ backgroundColor: "#000", minHeight: "100vh", color: "white" }}>
      
      {/* Met à jour l'état 'search' */}
      <Filters onSearch={(val) => setSearch(val)} />

      {/* 2. Grille Principale (2 colonnes) */}
      <div className="grid-layout" style={{ 
        display: 'grid', 
        gridTemplateColumns: 'repeat(2, 1fr)', // 2 colonnes égales
        gap: '20px', 
        padding: '20px'
      }}>
        
        {/* --- Graphique Population (Largeur complète) --- */}
        <div style={{ ...cardStyle, gridColumn: 'span 2', minHeight: '480px' }}>
          <Card to="/page1">
            <h3 style={{ color: 'white', padding: '15px 20px 0', margin: 0 }}>Population par département</h3>
            {/* Conteneur de taille fixe pour brider le graphique Chart.js */}
            <div style={{ height: '380px', width: '100%' }}>
              <Page1 search={search} />
            </div>
          </Card>
        </div>

        {/* --- Deux petits graphiques côte à côte --- */}
        <div style={{ ...cardStyle, minHeight: '300px' }}>
          <Card to="/page2">
             <Page2 search={search} />
          </Card>
        </div>
        
        <div style={{ ...cardStyle, minHeight: '300px' }}>
          <Card to="/page3">
             <Page3 search={search} />
          </Card>
        </div>

        {/* --- Comparaison Sociale (Largeur complète) --- */}
        <div style={{ ...cardStyle, gridColumn: 'span 2', minHeight: '320px', marginTop: '10px' }}>
          <Card to="/page4">
             <h3 style={{ color: 'white', padding: '15px 20px 0', margin: 0 }}>Comparaison Chômage vs Pauvreté</h3>
             <div style={{ height: '250px', width: '100%' }}>
                <Page4 search={search} />
             </div>
          </Card>
        </div>
        
      </div>
    </div>
  );
}