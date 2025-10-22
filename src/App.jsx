import Header from "./components/Header";
import Footer from "./components/Footer";
import AppRouter from "./router/AppRouter";
import { AuthProvider } from "./context/AuthContext";
import { RidesProvider } from "./context/RidesContext";

/**
 * ⚙️ Composant racine sans Router (le Router est déjà défini dans main.jsx)
  */
  function App() {
    return (
        <AuthProvider>
              <RidesProvider>
                      <div className="flex flex-col min-h-screen bg-green-50">
                                <Header />
                                          <main className="flex-grow">
                                                      <AppRouter />
                                                                </main>
                                                                          <Footer />
                                                                                  </div>
                                                                                        </RidesProvider>
                                                                                            </AuthProvider>
                                                                                              );
                                                                                              }

                                                                                              export default App;
                                                                                              
