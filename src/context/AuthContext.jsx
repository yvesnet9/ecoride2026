import { createContext, useState, useContext, useEffect } from "react";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [currentUser, setCurrentUser] = useState(null);
    const [reservations, setReservations] = useState([]);

      // 🔁 Charger l'utilisateur depuis le localStorage au démarrage
        useEffect(() => {
            const savedUser = localStorage.getItem("user");
                if (savedUser) {
                      setCurrentUser(JSON.parse(savedUser));
                          }
                            }, []);

                              // ✅ Connexion (stocke dans le localStorage)
                                const login = (email) => {
                                    const loggedUser = { email };
                                        setCurrentUser(loggedUser);
                                            localStorage.setItem("user", JSON.stringify(loggedUser));
                                              };

                                                // 🚪 Déconnexion
                                                  const logout = () => {
                                                      setCurrentUser(null);
                                                          localStorage.removeItem("user");
                                                            };

                                                              return (
                                                                  <AuthContext.Provider
                                                                        value={{ currentUser, login, logout, reservations, setReservations }}
                                                                            >
                                                                                  {children}
                                                                                      </AuthContext.Provider>
                                                                                        );
                                                                                        };

                                                                                        export const useAuth = () => useContext(AuthContext);
                                                                                        
