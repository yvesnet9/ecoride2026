import { createContext, useContext, useState, useEffect } from "react";

// Création du contexte
const AuthContext = createContext();

// Hook pour l'utiliser facilement
export const useAuth = () => useContext(AuthContext);

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);

    // Charger l'utilisateur depuis localStorage au démarrage
      useEffect(() => {
          const storedUser = localStorage.getItem("ecorideUser");
              if (storedUser) setUser(JSON.parse(storedUser));
                }, []);

                  // Fonction de connexion
                    const login = (email) => {
                        const fakeUser = { email };
                            setUser(fakeUser);
                                localStorage.setItem("ecorideUser", JSON.stringify(fakeUser));
                                  };

                                    // Fonction de déconnexion
                                      const logout = () => {
                                          setUser(null);
                                              localStorage.removeItem("ecorideUser");
                                                };

                                                  return (
                                                      <AuthContext.Provider value={{ user, login, logout }}>
                                                            {children}
                                                                </AuthContext.Provider>
                                                                  );
                                                                  };
                                                                  
