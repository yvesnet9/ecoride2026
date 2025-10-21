import { useRides } from "../context/RidesContext";
import RideStatusManager from "../components/RideStatusManager";

export default function ProfileRides() {
  const { rides } = useRides();
    const driverRides = rides.filter(
        (ride) => ride.driver === "admin@ecoride.fr"
          );

            return (
                <div className="max-w-3xl mx-auto mt-8">
                      <h2 className="text-2xl font-bold mb-4">Mes covoiturages (chauffeur)</h2>
                            {driverRides.length === 0 ? (
                                    <p className="text-gray-500">Aucun covoiturage disponible.</p>
                                          ) : (
                                                  driverRides.map((ride) => (
                                                            <RideStatusManager key={ride.id} ride={ride} />
                                                                    ))
                                                                          )}
                                                                              </div>
                                                                                );
                                                                                }
                                                                                
