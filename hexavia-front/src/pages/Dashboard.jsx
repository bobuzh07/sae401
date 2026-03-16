import Card from "../components/Card";
import Filters from "../components/Filters";

export default function Dashboard() {
  return (
    <><Filters></Filters><div className="grid-layout">
      <div className="card large">
        <Card to="/page1" />
      </div>
      <Card to="/page2" />
      <Card to="/page3" />
      <div className="card large">
        <Card to="/page4" />
      </div>
    </div></>
  );
}