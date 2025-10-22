import { StrictMode } from "react";
import { createRoot } from "react-dom/client";
import { BrowserRouter } from "react-router-dom";
import "./index.css";
import App from "./App.jsx";

// 🧠 Contextes globaux
import { AuthProvider } from "./context/AuthContext.jsx";
import { RidesProvider } from "./context/RidesContext.jsx";
import { FeedbackProvider } from "./context/FeedbackContext.jsx";

createRoot(document.getElementById("root")).render(
  <StrictMode>
      {/* ✅ Un seul Router global */}
          <BrowserRouter>
                {/* Contexte global des feedbacks (avis & signalements) */}
                      <FeedbackProvider>
                              {/* Contexte global de l'authentification */}
                                      <AuthProvider>
                                                {/* Contexte global des trajets */}
                                                          <RidesProvider>
                                                                      <App />
                                                                                </RidesProvider>
                                                                                        </AuthProvider>
                                                                                              </FeedbackProvider>
                                                                                                  </BrowserRouter>
                                                                                                    </StrictMode>
                                                                                                    );
                                                                                                    
