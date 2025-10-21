import { createContext, useContext, useState } from "react";

const RidesContext = createContext();

export function RidesProvider({ children }) {
  const [rides, setRides] = useState([
      {
            id: 1,
                  title: "Paris → Lyon",
                        departure: "Paris",
                              arrival: "Lyon",
                                    date: "21/10/2025",
                                          status: "planned",
                                                driver: "admin@ecoride.fr",
                                                      passengers: ["user@ecoride.fr"],
                                                          },
                                                              {
                                                                    id: 2,
                                                                          title: "Marseille → Nice",
                                                                                departure: "Marseille",
                                                                                      arrival: "Nice",
                                                                                            date: "19/10/2025",
                                                                                                  status: "completed",
                                                                                                        driver: "admin@ecoride.fr",
                                                                                                              passengers: ["user@ecoride.fr"],
                                                                                                                  },
                                                                                                                    ]);

                                                                                                                      /**
                                                                                                                         * Met à jour le statut d’un covoiturage
                                                                                                                            * @param {number} id - ID du covoiturage
                                                                                                                               * @param {string} newStatus - Nouveau statut (planned, in_progress, completed)
                                                                                                                                  */
                                                                                                                                    const updateRideStatus = (id, newStatus) => {
                                                                                                                                        setRides((prevRides) => {
                                                                                                                                              const updated = prevRides.map((ride) =>
                                                                                                                                                      ride.id === id ? { ...ride, status: newStatus } : ride
                                                                                                                                                            );

                                                                                                                                                                  // Trouver le trajet mis à jour (dans la nouvelle version)
                                                                                                                                                                        const updatedRide = updated.find((r) => r.id === id);

                                                                                                                                                                              // Simulation d'envoi de notification aux passagers
                                                                                                                                                                                    if (updatedRide && newStatus === "completed") {
                                                                                                                                                                                            updatedRide.passengers.forEach((email) => {
                                                                                                                                                                                                      alert(
                                                                                                                                                                                                                  `📩 Notification envoyée à ${email} : le covoiturage "${updatedRide.title}" est terminé.\nVeuillez confirmer votre expérience dans votre espace passager.`
                                                                                                                                                                                                                            );
                                                                                                                                                                                                                                    });
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                                return updated;
                                                                                                                                                                                                                                                    });
                                                                                                                                                                                                                                                      };

                                                                                                                                                                                                                                                        return (
                                                                                                                                                                                                                                                            <RidesContext.Provider value={{ rides, updateRideStatus }}>
                                                                                                                                                                                                                                                                  {children}
                                                                                                                                                                                                                                                                      </RidesContext.Provider>
                                                                                                                                                                                                                                                                        );
                                                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                                                        /**
                                                                                                                                                                                                                                                                         * Hook personnalisé pour accéder facilement au contexte des covoiturages
                                                                                                                                                                                                                                                                          */
                                                                                                                                                                                                                                                                          export const useRides = () => useContext(RidesContext);
                                                                                                                                                                                                                                                                          
