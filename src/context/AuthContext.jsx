import { createContext, useContext, useState, useEffect } from "react";

const AuthContext = createContext();
export const useAuth = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
    const [reservations, setReservations] = useState([]);

      useEffect(() => {
          const storedUser = localStorage.getItem("ecorideUser");
              const storedReservations = localStorage.getItem("ecorideReservations");
                  if (storedUser) setUser(JSON.parse(storedUser));
                      if (storedReservations) setReservations(JSON.parse(storedReservations));
                        }, []);

                          useEffect(() => {
                              localStorage.setItem("ecorideReservations", JSON.stringify(reservations));
                                }, [reservations]);

                                  const login = (email) => {
                                      const fakeUser = {
                                            email,
                                                  isAdmin: email === "admin@ecoride.fr", // ✅ admin unique
                                                      };
                                                          setUser(fakeUser);
                                                              localStorage.setItem("ecorideUser", JSON.stringify(fakeUser));
                                                                };

                                                                  const logout = () => {
                                                                      setUser(null);
                                                                          localStorage.removeItem("ecorideUser");
                                                                            };

                                                                              const reserveRide = (ride) => {
                                                                                  const exists = reservations.find((r) => r.id === ride.id);
                                                                                      if (!exists) {
                                                                                            setReservations([...reservations, ride]);
                                                                                                  alert("✅ Trajet réservé avec succès !");
                                                                                                      } else {
                                                                                                            alert("ℹ️ Vous avez déjà réservé ce trajet.");
                                                                                                                }
                                                                                                                  };

                                                                                                                    const cancelReservation = (id) => {
                                                                                                                        setReservations(reservations.filter((r) => r.id !== id));
                                                                                                                          };

                                                                                                                            return (
                                                                                                                                <AuthContext.Provider
                                                                                                                                      value={{
                                                                                                                                              user,
                                                                                                                                                      login,
                                                                                                                                                              logout,
                                                                                                                                                                      reservations,
                                                                                                                                                                              reserveRide,
                                                                                                                                                                                      cancelReservation,
                                                                                                                                                                                            }}
                                                                                                                                                                                                >
                                                                                                                                                                                                      {children}
                                                                                                                                                                                                          </AuthContext.Provider>
                                                                                                                                                                                                            );
                                                                                                                                                                                                            };
                                                                                                                                                                                                            
