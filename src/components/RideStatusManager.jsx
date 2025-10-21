import { useState } from "react";
import { useRides } from "../context/RidesContext";

export default function RideStatusManager({ ride }) {
  const { updateRideStatus } = useRides();
    const [status, setStatus] = useState(ride.status || "planned");
      const [loading, setLoading] = useState(false);

        const handleStart = async () => {
            setLoading(true);
                await new Promise((res) => setTimeout(res, 800)); // Simulation d’appel API
                    setStatus("in_progress");
                        updateRideStatus(ride.id, "in_progress");
                            setLoading(false);
                                alert(`🚗 Le covoiturage "${ride.title}" a démarré !`);
                                  };

                                    const handleComplete = async () => {
                                        setLoading(true);
                                            await new Promise((res) => setTimeout(res, 800));
                                                setStatus("completed");
                                                    updateRideStatus(ride.id, "completed");
                                                        setLoading(false);
                                                            alert(`✅ Le covoiturage "${ride.title}" est terminé. Les passagers vont être notifiés.`);
                                                              };

                                                                return (
                                                                    <div className="flex items-center justify-between p-4 bg-white rounded-2xl shadow-sm border mb-3">
                                                                          <div>
                                                                                  <h3 className="font-semibold text-gray-800">{ride.title}</h3>
                                                                                          <p className="text-sm text-gray-500">
                                                                                                    {ride.departure} → {ride.arrival} ({ride.date})
                                                                                                            </p>
                                                                                                                  </div>

                                                                                                                        <div>
                                                                                                                                {status === "planned" && (
                                                                                                                                          <button
                                                                                                                                                      onClick={handleStart}
                                                                                                                                                                  disabled={loading}
                                                                                                                                                                              className="bg-emerald-500 text-white px-4 py-2 rounded-xl hover:bg-emerald-600 transition"
                                                                                                                                                                                        >
                                                                                                                                                                                                    {loading ? "Démarrage..." : "Démarrer"}
                                                                                                                                                                                                              </button>
                                                                                                                                                                                                                      )}

                                                                                                                                                                                                                              {status === "in_progress" && (
                                                                                                                                                                                                                                        <button
                                                                                                                                                                                                                                                    onClick={handleComplete}
                                                                                                                                                                                                                                                                disabled={loading}
                                                                                                                                                                                                                                                                            className="bg-blue-500 text-white px-4 py-2 rounded-xl hover:bg-blue-600 transition"
                                                                                                                                                                                                                                                                                      >
                                                                                                                                                                                                                                                                                                  {loading ? "Clôture..." : "Arrivée à destination"}
                                                                                                                                                                                                                                                                                                            </button>
                                                                                                                                                                                                                                                                                                                    )}

                                                                                                                                                                                                                                                                                                                            {status === "completed" && (
                                                                                                                                                                                                                                                                                                                                      <span className="text-green-600 font-semibold">Terminé ✔️</span>
                                                                                                                                                                                                                                                                                                                                              )}
                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                          );
                                                                                                                                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                                                                                                                                          
