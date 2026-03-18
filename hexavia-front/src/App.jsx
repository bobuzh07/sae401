import { Routes, Route } from "react-router-dom";
import Dashboard from "./pages/Dashboard";
import Page1 from "./pages/Page1";
import Page2 from "./pages/Page2";
import Page3 from "./pages/Page3";
import Page4 from "./pages/Page4";
import Header from "./components/Header";
import Footer from "./components/Footer";
import "./App.css";
import { useEffect, useState } from "react";

function App() {
  const [stats, setStats] = useState([]);

  useEffect(() => {
    fetch("http://localhost:8000/api/stats")
      .then(res => res.json())
      .then(data => {
        console.log("Stats reçues :", data);
        setStats(data);
      })
      .catch(err => console.error("Erreur fetch stats :", err));
  }, []);
  
  return (
    <>
      <Header />
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="/page1" element={<Page1 />} />
        <Route path="/page2" element={<Page2 />} />
        <Route path="/page3" element={<Page3 />} />
        <Route path="/page4" element={<Page4 />} />
      </Routes>
      <div>
        <p>Statistiques de chômage par ville</p>
        {stats.map((stat, index) => (
          <p key={index}>
            {stat.city} : {stat.unemployment_rate}%
          </p>
        ))}
      </div>
      <Footer />
    </>
  );

}

export default App;