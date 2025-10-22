import { createContext, useContext, useState, useEffect } from "react";

/**
 * 👥 UserContext
  * Centralise tous les utilisateurs (admin, employés, chauffeurs, passagers)
   * et leurs rôles.
    */
    const UserContext = createContext();

    export function UserProvider({ children }) {
      // 🧩 Liste globale des utilisateurs
        const [users, setUsers] = useState([
            { email: "admin@ecoride.fr", role: "admin" },
                { email: "employee@ecoride.fr", role: "employee" },
                    { email: "driver@ecoride.fr", role: "driver" },
                        { email: "user@ecoride.fr", role: "passenger" },
                          ]);

                            // 💾 Persistance locale (simulation base de données)
                              useEffect(() => {
                                  const stored = localStorage.getItem("users");
                                      if (stored) setUsers(JSON.parse(stored));
                                        }, []);

                                          useEffect(() => {
                                              localStorage.setItem("users", JSON.stringify(users));
                                                }, [users]);

                                                  /** ➕ Ajouter un utilisateur */
                                                    const addUser = (email, role = "employee") => {
                                                        if (!email) return;
                                                            if (users.find((u) => u.email === email)) {
                                                                  alert("❌ Cet utilisateur existe déjà !");
                                                                        return;
                                                                            }
                                                                                const newUser = { email, role };
                                                                                    setUsers((prev) => [...prev, newUser]);
                                                                                      };

                                                                                        /** 🗑️ Supprimer un utilisateur */
                                                                                          const removeUser = (email) => {
                                                                                              if (email === "admin@ecoride.fr") {
                                                                                                    alert("⚠️ Vous ne pouvez pas supprimer l’administrateur principal !");
                                                                                                          return;
                                                                                                              }
                                                                                                                  setUsers((prev) => prev.filter((u) => u.email !== email));
                                                                                                                    };

                                                                                                                      /** 🔁 Modifier le rôle d’un utilisateur */
                                                                                                                        const updateUserRole = (email, newRole) => {
                                                                                                                            setUsers((prev) =>
                                                                                                                                  prev.map((u) => (u.email === email ? { ...u, role: newRole } : u))
                                                                                                                                      );
                                                                                                                                        };

                                                                                                                                          /** 🔍 Trouver un utilisateur par email */
                                                                                                                                            const findUserByEmail = (email) => users.find((u) => u.email === email);

                                                                                                                                              return (
                                                                                                                                                  <UserContext.Provider
                                                                                                                                                        value={{
                                                                                                                                                                users,
                                                                                                                                                                        addUser,
                                                                                                                                                                                removeUser,
                                                                                                                                                                                        updateUserRole,
                                                                                                                                                                                                findUserByEmail,
                                                                                                                                                                                                      }}
                                                                                                                                                                                                          >
                                                                                                                                                                                                                {children}
                                                                                                                                                                                                                    </UserContext.Provider>
                                                                                                                                                                                                                      );
                                                                                                                                                                                                                      }

                                                                                                                                                                                                                      /** Hook personnalisé pour y accéder facilement */
                                                                                                                                                                                                                      export const useUsers = () => useContext(UserContext);
                                                                                                                                                                                                                      
