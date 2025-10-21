import { useState } from "react";
import { useNavigate } from "react-router-dom";

export default function Home() {
  const [departure, setDeparture] = useState("");
  const [arrival, setArrival] = useState("");
  const [date, setDate] = useState("");
  const navigate = useNavigate();

  const handleSearch = (e) => {
    e.preventDefault();

    if (!departure || !arrival) {
      alert("🚨 Veuillez remplir les champs de départ et d’arrivée.");
      return;
    }

    // Redirection vers la page des covoiturages
    navigate("/rides");
  };

  return (
    <div className="flex flex-col items-center justify-center min-h-[80vh] bg-green-50 text-center p-8">
      <h1 className="text-4xl font-bold text-green-700 mb-4">
        Bienvenue sur 🌿 EcoRide
      </h1>

      <p className="text-gray-700 max-w-xl mb-6">
        Trouvez facilement un covoiturage écologique près de chez vous.
        Ensemble, réduisons notre empreinte carbone 🌍
      </p>

      {/* ✅ Formulaire de recherche */}
      <form
        onSubmit={handleSearch}
        className="bg-white shadow-lg rounded-lg p-6 flex flex-col md:flex-row items-center gap-4 w-full max-w-2xl"
      >
        <input
          type="text"
          placeholder="Départ"
          value={departure}
          onChange={(e) => setDeparture(e.target.value)}
          className="border border-gray-300 rounded px-4 py-2 w-full md:w-1/3 focus:ring-2 focus:ring-green-500"
        />
        <input
          type="text"
          placeholder="Arrivée"
          value={arrival}
          onChange={(e) => setArrival(e.target.value)}
          className="border border-gray-300 rounded px-4 py-2 w-full md:w-1/3 focus:ring-2 focus:ring-green-500"
        />
        <input
          type="date"
          value={date}
          onChange={(e) => setDate(e.target.value)}
          className="border border-gray-300 rounded px-4 py-2 w-full md:w-1/4 focus:ring-2 focus:ring-green-500"
        />
        <button
          type="submit"
          className="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition w-full md:w-auto"
        >
          Rechercher
        </button>
      </form>

      <p className="text-gray-600 mt-4">
        Vous pouvez aussi consulter tous les trajets disponibles dans la section{" "}
        <span className="text-green-600 font-semibold">Covoiturages</span>.
      </p>

      <img
        src="https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1000&q=60"
        alt="EcoRide voiture verte"
        className="rounded-2xl shadow-md mt-8 w-full max-w-lg"
      />

      <p className="mt-6 text-gray-600">
        <strong>🌱 Simple, économique et écologique.</strong>
        <br />
        Rejoignez le mouvement EcoRide dès aujourd’hui !
      </p>
    </div>
  );
}
