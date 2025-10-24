import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext.jsx";

/**
 * 🔒 ProtectedEmployeeRoute
  * --------------------------------------------------
   * Protège les routes réservées aux employés EcoRide.
    * Actuellement, seul "admin@ecoride.fr" a accès.
     * (Ce sera étendu à "employee@ecoride.fr" dans l'US13)
      */
      export default function ProtectedEmployeeRoute({ children }) {
        // 1️⃣ Récupération de l'utilisateur connecté via le contexte d'authentification
          const { currentUser } = useAuth();

            // 2️⃣ Si aucun utilisateur n'est connecté → redirection vers la page de connexion
              if (!currentUser) {
                  return <Navigate to="/login" replace />;
                    }

                      // 3️⃣ Liste des adresses autorisées (administrateur et employés)
                        const authorizedEmails = ["admin@ecoride.fr", "employee@ecoride.fr"];

                          // 4️⃣ Si l’utilisateur n’est pas dans la liste autorisée → redirection vers la page d’accueil
                            if (!authorizedEmails.includes(currentUser.email)) {
                                return <Navigate to="/" replace />;
                                  }

                                    // 5️⃣ Sinon → autorisation d’accès à la route protégée
                                      return children;
                                      }
                                      
