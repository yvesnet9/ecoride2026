import { createContext, useState, useContext, useEffect } from "react";

const AuthContext = createContext();

/**
 * ✅ AuthProvider :
 * Gère l'authentification + les rôles utilisateurs (admin, employee, driver, passenger)
 */
export const AuthProvider = ({ children }) => {
  // 🧠 Utilisateur actuellement connecté
  const [user, setUser] = useState(null);

  // 🚗 Réservations ou autres données utilisateur (placeholder)
  const [reservations, setReservations] = useState([]);

  // 🧩 Base de données simulée (sera remplacée plus tard par une vraie API)
  const USERS = [
    { email: "admin@ecoride.fr", role: "admin" },
    { email: "employee@ecoride.fr", role: "employee" },
    { email: "driver@ecoride.fr", role: "driver" },
    { email: "user@ecoride.fr", role: "passenger" },
  ];

  // 🔁 Charger l'utilisateur depuis le localStorage au démarrage
  useEffect(() => {
    const savedUser = localStorage.getItem("user");
    if (savedUser) {
      setUser(JSON.parse(savedUser));
    }
  }, []);

  /**
   * ✅ Connexion d’un utilisateur
   * Associe automatiquement un rôle selon l’adresse email.
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
      `✅ Connecté en tant que ${foundUser.role.toUpperCase()} (${
        foundUser.email
      })`
    );
  };

  /**
   * 🚪 Déconnexion
   */
  const logout = () => {
    setUser(null);
    localStorage.removeItem("user");
  };

  return (
    <AuthContext.Provider
      value={{
        user,
        login,
        logout,
        reservations,
        setReservations,
      }}
    >
      {children}
    </AuthContext.Provider>
  );
};

/**
 * 🔌 Hook personnalisé pour accéder facilement à l’authentification
 */
export const useAuth = () => useContext(AuthContext);
