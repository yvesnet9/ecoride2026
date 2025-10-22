import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext.jsx";

/**
 * Protège les routes réservées aux employés EcoRide.
  * Actuellement, seul "admin@ecoride.fr" a accès (sera élargi à "employee@ecoride.fr" dans l'US13).
   */
   export default function ProtectedEmployeeRoute({ children }) {
     const { currentUser } = useAuth();

       // Aucun utilisateur connecté
         if (!currentUser) {
             return <Navigate to="/login" replace />;
               }

                 // Vérifie si l'utilisateur est autorisé
                   const authorizedEmails = ["admin@ecoride.fr", "employee@ecoride.fr"];

                     if (!authorizedEmails.includes(currentUser.email)) {
                         return <Navigate to="/" replace />;
                           }

                             // Autorisation accordée
                               return children;
                               }
                               
