import { createContext, useState, useContext, useEffect } from "react";

// 🧩 Création du contexte global d’authentification
const AuthContext = createContext();

/**
 * ✅ AuthProvider :
  * Gère l'authentification et les rôles utilisateurs (admin, employee, driver, passenger).
   * Ce composant englobe toute l’application pour partager l’état de connexion.
    */
    export const AuthProvider = ({ children }) => {
      // 1️⃣ Utilisateur actuellement connecté
        const [user, setUser] = useState(null);

          // 2️⃣ Exemple de données liées à l’utilisateur (ici des réservations fictives)
            const [reservations, setReservations] = useState([]);

              // 3️⃣ Base d’utilisateurs simulée (remplaçable par une vraie API plus tard)
                const USERS = [
                    { email: "admin@ecoride.fr", role: "admin" },
                        { email: "employee@ecoride.fr", role: "employee" },
                            { email: "driver@ecoride.fr", role: "driver" },
                                { email: "user@ecoride.fr", role: "passenger" },
                                  ];

                                    // 4️⃣ Au chargement de l’application, on vérifie si un utilisateur est stocké dans le localStorage
                                      useEffect(() => {
                                          const savedUser = localStorage.getItem("user");
                                              if (savedUser) {
                                                    setUser(JSON.parse(savedUser));
                                                        }
                                                          }, []);

                                                            /**
                                                               * ✅ Fonction de connexion
                                                                  * Simule une authentification : on recherche l’adresse email dans la base USERS.
                                                                     * Si trouvée → on sauvegarde l’utilisateur et son rôle dans le localStorage.
                                                                        */
                                                                          const login = (email) => {
                                                                              const foundUser = USERS.find((u) => u.email === email);

                                                                                  if (!foundUser) {
                                                                                        alert("❌ Utilisateur inconnu !");
                                                                                              return;
                                                                                                  }

                                                                                                      const loggedUser = { email: foundUser.email, role: foundUser.role };
                                                                                                          setUser(loggedUser);
                                                                                                              localStorage.setItem("user", JSON.stringify(loggedUser));

                                                                                                                  alert(
                                                                                                                        `✅ Connecté en tant que ${foundUser.role.toUpperCase()} (${foundUser.email})`
                                                                                                                            );
                                                                                                                              };

                                                                                                                                /**
                                                                                                                                   * 🚪 Fonction de déconnexion
                                                                                                                                      * Supprime les données de l’utilisateur et vide le localStorage.
                                                                                                                                         */
                                                                                                                                           const logout = () => {
                                                                                                                                               setUser(null);
                                                                                                                                                   localStorage.removeItem("user");
                                                                                                                                                     };

                                                                                                                                                       /**
                                                                                                                                                          * 📦 Fournit les données et fonctions à tout le reste de l’application
                                                                                                                                                             */
                                                                                                                                                               return (
                                                                                                                                                                   <AuthContext.Provider
                                                                                                                                                                         value={{
                                                                                                                                                                                 user, // utilisateur actuel
                                                                                                                                                                                         login, // fonction de connexion
                                                                                                                                                                                                 logout, // fonction de déconnexion
                                                                                                                                                                                                         reservations,
                                                                                                                                                                                                                 setReservations,
                                                                                                                                                                                                                       }}
                                                                                                                                                                                                                           >
                                                                                                                                                                                                                                 {children}
                                                                                                                                                                                                                                     </AuthContext.Provider>
                                                                                                                                                                                                                                       );
                                                                                                                                                                                                                                       };

                                                                                                                                                                                                                                       /**
                                                                                                                                                                                                                                        * 🔌 Hook personnalisé : permet d’accéder facilement à l’authentification
                                                                                                                                                                                                                                         * Exemple d’utilisation : const { user, login, logout } = useAuth();
                                                                                                                                                                                                                                          */
                                                                                                                                                                                                                                          export const useAuth = () => useContext(AuthContext);
                                                                                                                                                                                                                                          
