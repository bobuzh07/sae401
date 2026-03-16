export default function Filters() {
  return (
    <div style={{ padding: "0 40px", marginTop: "20px" }}>
      <p>Selection des Critères :</p>

      <div style={{ display: "flex", gap: "15px" }}>
        <select>
          <option>Région</option>
        </select>

        <select>
          <option>Département</option>
        </select>

        <select>
          <option>Année</option>
        </select>
      </div>
    </div>
  );
}