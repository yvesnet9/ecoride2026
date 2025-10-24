import { Navigate } from "react-router-dom";

/**
 * 🔓 Version temporaire : accès libre pendant le développement
  */
  export default function ProtectedAdminRoute({ children }) {
    const devMode = true; // accès libre
      if (devMode) return children;

        // 🧱 (future logique authentification)
          // const user = JSON.parse(localStorage.getItem("user"));
            // const isAdmin = user && user.role === "admin";
              // return isAdmin ? children : <Navigate to="/login" replace />;

                return <Navigate to="/login" replace />;
                }
                
