import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

export default function ProtectedAdminRoute({ children }) {
  const { user } = useAuth();

    // 🚧 Si pas connecté → redirection vers /login
      if (!user) {
          return <Navigate to="/login" />;
            }

              // 🚫 Si connecté mais pas admin → accès refusé
                if (user.email !== "admin@ecoride.fr") {
                    return (
                          <div className="text-center py-20">
                                  <h1 className="text-3xl font-bold text-red-600 mb-4">🚫 Accès refusé</h1>
                                          <p className="text-gray-600">Seul un administrateur peut voir cette page.</p>
                                                </div>
                                                    );
                                                      }

                                                        // ✅ Sinon → accès autorisé
                                                          return children;
                                                          }
                                                          
