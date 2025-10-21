import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext.jsx";

/**
 * Protège les routes réservées à l’administrateur
  * Seul l’utilisateur "admin@ecoride.fr" peut y accéder.
   */
   export default function ProtectedAdminRoute({ children }) {
     const { currentUser } = useAuth();

       // Si aucun utilisateur n’est connecté, on redirige vers /login
         if (!currentUser) {
             return <Navigate to="/login" replace />;
               }

                 // Si l’utilisateur n’est pas l’administrateur, on redirige vers /
                   if (currentUser.email !== "admin@ecoride.fr") {
                       return <Navigate to="/" replace />;
                         }

                           // Sinon, on autorise l’accès à la route protégée
                             return children;
                             }
                             
