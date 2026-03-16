import { Link } from "react-router-dom";

export default function Card({ to }) {
  return (
    <Link to={to} style={{ textDecoration: "none" }}>
      <div className="card"></div>
    </Link>
  );
}