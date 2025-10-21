import { useParams, Link } from "react-router-dom";
import { rides } from "../data/rides";

export default function RideDetail() {
  const { id } = useParams();
    const ride = rides.find((r) => r.id === parseInt(id));

      if (!ride) {
          return (
                <div className="text-center py-10">
                        <h1 className="text-2xl text-red-600">🚫 Trajet introuvable</h1>
                                <Link
                                          to="/rides"
                                                    className="mt-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition"
                                                            >
                                                                      Retour aux covoiturages
                                                                              </Link>
                                                                                    </div>
                                                                                        );
                                                                                          }

                                                                                            return (
                                                                                                <div className="container mx-auto py-10">
                                                                                                      <h1 className="text-3xl font-bold text-green-700 mb-6 text-center">
                                                                                                              🚗 Détails du trajet
                                                                                                                    </h1>

                                                                                                                          <div className="bg-white rounded-lg shadow-md p-6 max-w-xl mx-auto">
                                                                                                                                  <h2 className="text-2xl font-semibold text-green-600 mb-4">
                                                                                                                                            {ride.departure} → {ride.arrival}
                                                                                                                                                    </h2>

                                                                                                                                                            <div className="text-gray-700 space-y-2 mb-6">
                                                                                                                                                                      <p><strong>👤 Conducteur :</strong> {ride.driver}</p>
                                                                                                                                                                                <p><strong>📅 Date :</strong> {ride.date}</p>
                                                                                                                                                                                          <p><strong>💺 Places disponibles :</strong> {ride.seats}</p>
                                                                                                                                                                                                    <p><strong>💶 Prix par place :</strong> {ride.price} €</p>
                                                                                                                                                                                                            </div>

                                                                                                                                                                                                                    <button className="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                                                                                                                                                                                                                              Réserver maintenant
                                                                                                                                                                                                                                      </button>

                                                                                                                                                                                                                                              <div className="mt-6">
                                                                                                                                                                                                                                                        <Link
                                                                                                                                                                                                                                                                    to="/rides"
                                                                                                                                                                                                                                                                                className="text-green-600 hover:underline"
                                                                                                                                                                                                                                                                                          >
                                                                                                                                                                                                                                                                                                      ← Retour à la liste
                                                                                                                                                                                                                                                                                                                </Link>
                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                                                                                                                    );
                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                    
