import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

export default function ProtectedAdminRoute({ children }) {
  const { user } = useAuth();

    if (!user) {
        // pas connecté → redirection vers /login
            return <Navigate to="/login" replace />;
              }

                if (!user.isAdmin) {
                    // connecté mais pas admin
                        return (
                              <div className="text-center py-20">
                                      <h1 className="text-2xl font-bold text-red-600">
                                                🚫 Accès refusé
                                                        </h1>
                                                                <p className="text-gray-600 mt-2">
                                                                          Vous devez être connecté avec un compte administrateur pour accéder à cette page.
                                                                                  </p>
                                                                                        </div>
                                                                                            );
                                                                                              }

                                                                                                return children;
                                                                                                }
                                                                                                
