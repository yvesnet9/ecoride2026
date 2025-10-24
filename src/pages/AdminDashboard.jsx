import { useEffect, useState, useMemo } from "react";
import {
  PieChart,
  Pie,
  Cell,
  Tooltip,
  ResponsiveContainer,
  Legend,
  BarChart,
  Bar,
  XAxis,
  YAxis,
  CartesianGrid,
} from "recharts";
import FadePage from "../components/FadePage"; // 🌿 Animation d’apparition

export default function AdminDashboard() {
  const [stats, setStats] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // 🧭 Charger les statistiques depuis l’API PHP
  useEffect(() => {
    const fetchData = async () => {
      try {
        const res = await fetch("http://localhost:8000/api/dashboard.php");
        const data = await res.json();
        if (data.error) throw new Error(data.error);
        setStats(data);
      } catch (err) {
        console.error("Erreur Dashboard:", err);
        setError("Impossible de récupérer les données du tableau de bord.");
      } finally {
        setLoading(false);
      }
    };
    fetchData();
  }, []);

  // 🌈 Couleurs du graphique
  const COLORS = ["#22c55e", "#16a34a", "#15803d", "#4ade80", "#86efac"];

  // 📊 Données formatées pour les graphiques
  const driverData = useMemo(() => stats?.ridesByDriver || [], [stats]);
  const ridesByDate = useMemo(() => stats?.ridesByDate || [], [stats]);

  return (
    <FadePage>
      <div className="min-h-[85vh] bg-green-50 py-10">
        <div className="container mx-auto px-4">
          <h1 className="text-3xl font-bold text-green-700 mb-6 text-center">
            📊 Tableau de bord - Administration
          </h1>

          {/* === LOADER / ERREUR === */}
          {loading && (
            <p className="text-center text-gray-600">
              Chargement des données...
            </p>
          )}
          {error && (
            <p className="text-center text-red-600 font-semibold">{error}</p>
          )}

          {/* === DONNÉES === */}
          {stats && (
            <>
              {/* ==== STATS PRINCIPALES ==== */}
              <div className="grid md:grid-cols-3 gap-6 mb-10">
                <div className="bg-white rounded-xl shadow p-6 text-center">
                  <h2 className="text-3xl font-bold text-green-700">
                    {stats.totalRides}
                  </h2>
                  <p className="text-gray-600 mt-2">Trajets disponibles</p>
                </div>
                <div className="bg-white rounded-xl shadow p-6 text-center">
                  <h2 className="text-3xl font-bold text-green-700">
                    {stats.totalReservations}
                  </h2>
                  <p className="text-gray-600 mt-2">Réservations effectuées</p>
                </div>
                <div className="bg-white rounded-xl shadow p-6 text-center">
                  <h2 className="text-3xl font-bold text-green-700">
                    {stats.uniqueDrivers}
                  </h2>
                  <p className="text-gray-600 mt-2">Conducteurs actifs</p>
                </div>
              </div>

              {/* ==== GRAPHIQUE CIRCULAIRE ==== */}
              <div className="bg-white rounded-xl shadow p-8 mb-10">
                <h2 className="text-xl font-semibold text-green-700 mb-4 text-center">
                  Répartition des trajets par conducteur
                </h2>
                <div className="h-80">
                  {driverData.length === 0 ? (
                    <p className="text-gray-500 text-center">
                      Aucune donnée disponible pour le graphique.
                    </p>
                  ) : (
                    <ResponsiveContainer width="100%" height="100%">
                      <PieChart>
                        <Pie
                          data={driverData}
                          dataKey="value"
                          nameKey="name"
                          cx="50%"
                          cy="50%"
                          outerRadius={100}
                          label
                        >
                          {driverData.map((entry, index) => (
                            <Cell
                              key={`cell-${index}`}
                              fill={COLORS[index % COLORS.length]}
                            />
                          ))}
                        </Pie>
                        <Tooltip />
                        <Legend />
                      </PieChart>
                    </ResponsiveContainer>
                  )}
                </div>
              </div>

              {/* ==== GRAPHIQUE EN BARRES ==== */}
              <div className="bg-white rounded-xl shadow p-8 mb-10">
                <h2 className="text-xl font-semibold text-green-700 mb-4 text-center">
                  Évolution des trajets par date
                </h2>
                <div className="h-80">
                  {ridesByDate.length === 0 ? (
                    <p className="text-gray-500 text-center">
                      Aucune donnée de trajets à afficher.
                    </p>
                  ) : (
                    <ResponsiveContainer width="100%" height="100%">
                      <BarChart data={ridesByDate}>
                        <CartesianGrid strokeDasharray="3 3" />
                        <XAxis dataKey="date" />
                        <YAxis />
                        <Tooltip />
                        <Legend />
                        <Bar dataKey="count" fill="#16a34a" name="Trajets" />
                      </BarChart>
                    </ResponsiveContainer>
                  )}
                </div>
              </div>
            </>
          )}
        </div>
      </div>
    </FadePage>
  );
}
