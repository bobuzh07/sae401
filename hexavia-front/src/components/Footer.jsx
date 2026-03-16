export default function Footer() {
  return (
    <footer style={{ background: "#111", padding: "40px", marginTop: "auto" }}>
      <div style={{ display: "flex", justifyContent: "space-between" }}>
        <div>
          <h3>Hexavia</h3>
          <p>All rights reserved</p>
          <p>Copyrights © 2026</p>
        </div>

        <div>
          <h4>About</h4>
          <p>Mentions légales</p>
          <p>Cookies</p>
        </div>

        <div>
          <h4>Links</h4>
          <p>Facebook</p>
          <p>Instagram</p>
        </div>
      </div>
    </footer>
  );
}