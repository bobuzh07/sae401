import { useState, useEffect } from 'react';

export default function Filters({ onSearch }) {
  // État local pour que l'affichage de l'input soit instantané (fluide)
  const [inputValue, setInputValue] = useState("");

  useEffect(() => {
    // On crée un minuteur de 400ms avant de transmettre la recherche au parent (Dashboard)
    const timer = setTimeout(() => {
      onSearch(inputValue);
    }, 400);

    // Si l'utilisateur tape une nouvelle lettre avant la fin du minuteur précédent, on recommence un nouveau
    return () => clearTimeout(timer);
    
  }, [inputValue, onSearch]); // Se relance à chaque modification de l'input

  // Style réutilisable pour l'input
  const inputStyle = {
    width: '80%',
    maxWidth: '800px',
    padding: '12px 25px',
    borderRadius: '25px',
    border: 'none',
    fontSize: '16px',
    outline: 'none',
    boxShadow: '0 4px 6px rgba(0,0,0,0.1)'
  };

  return (
    <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', padding: '20px', color: 'white' }}>
      
      <p style={{ width: '80%', maxWidth: '800px', marginBottom: '8px' }}>
        Sélection des Critères (région ou département) :
      </p>

      <input
        type="text"
        placeholder="Rechercher un département ou une région..."
        value={inputValue}
        // Mise à jour de l'état local à chaque touche pressée
        onChange={(e) => setInputValue(e.target.value)} 
        style={inputStyle}
      />
      
    </div>
  );
}