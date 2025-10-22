import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter } from "react-router-dom";

import App from "./App.jsx";
import "./index.css";

// 🧩 Contexts globaux
import { UserProvider } from "./context/UserContext.jsx";
import { AuthProvider } from "./context/AuthContext.jsx";
import { RidesProvider } from "./context/RidesContext.jsx";
import { FeedbackProvider } from "./context/FeedbackContext.jsx";

/**
 * 🧠 Hiérarchie des providers :
  * BrowserRouter
   * └─ UserProvider          → Gestion des utilisateurs / rôles
    *    └─ FeedbackProvider   → Gestion des avis passagers
     *       └─ AuthProvider    → Connexion / déconnexion / rôle courant
      *          └─ RidesProvider→ Données covoiturages
       *             └─ App       → Application principale
        */

        createRoot(document.getElementById("root")).render(
          <StrictMode>
              <BrowserRouter>
                    <UserProvider>
                            <FeedbackProvider>
                                      <AuthProvider>
                                                  <RidesProvider>
                                                                <App />
                                                                            </RidesProvider>
                                                                                      </AuthProvider>
                                                                                              </FeedbackProvider>
                                                                                                    </UserProvider>
                                                                                                        </BrowserRouter>
                                                                                                          </StrictMode>
                                                                                                          );
                                                                                                          
