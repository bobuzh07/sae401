import React from "react";


export default function Card({ children }) {
  return (
    <div className="card" style={{ 
      height: "100%", 
      display: "flex", 
      flexDirection: "column",
      overflow: "hidden", 
      position: "relative",
    }}>
      {/* Conteneur interne pour le graphique */}
      <div style={{ flex: 1, width: "100%", position: "relative" }}>
        {children}
      </div>
    </div>
  );
}