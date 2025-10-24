import Header from "./components/Header";
import Footer from "./components/Footer";
import AppRouter from "./router/AppRouter";
import { AuthProvider } from "./context/AuthContext";
import { RidesProvider } from "./context/RidesContext";

/**
 * ⚙️ Composant racine de l’application EcoRide
  * -------------------------------------------------
   * - Gère le contexte global (authentification + trajets)
    * - Le routeur est déjà défini dans `main.jsx`
     * - Contient la structure principale : Header / Contenu / Footer
      */
      function App() {
        return (
            // 🌍 Fournit les données d'authentification à toute l'application
                <AuthProvider>
                      {/* 🚗 Fournit les données des trajets (Rides) à tous les composants */}
                            <RidesProvider>
                                    {/* 🧩 Structure globale de la page */}
                                            <div className="flex flex-col min-h-screen bg-green-50">
                                                      {/* 🔝 Barre de navigation / Logo */}
                                                                <Header />

                                                                          {/* 🧭 Zone centrale où le routeur affiche les pages */}
                                                                                    <main className="flex-grow">
                                                                                                <AppRouter />
                                                                                                          </main>

                                                                                                                    {/* 🔻 Pied de page commun à toutes les pages */}
                                                                                                                              <Footer />
                                                                                                                                      </div>
                                                                                                                                            </RidesProvider>
                                                                                                                                                </AuthProvider>
                                                                                                                                                  );
                                                                                                                                                  }

                                                                                                                                                  export default App;
                                                                                                                                                  
