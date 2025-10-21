import { BrowserRouter as Router } from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";
import AppRouter from "./router/AppRouter";
import { AuthProvider } from "./context/AuthContext";
import { RidesProvider } from "./context/RidesContext";

function App() {
  return (
      <AuthProvider>
            <RidesProvider>
                    <Router>
                              <div className="flex flex-col min-h-screen bg-green-50">
                                          <Header />
                                                      <main className="flex-grow">
                                                                    <AppRouter />
                                                                                </main>
                                                                                            <Footer />
                                                                                                      </div>
                                                                                                              </Router>
                                                                                                                    </RidesProvider>
                                                                                                                        </AuthProvider>
                                                                                                                          );
                                                                                                                          }

                                                                                                                          export default App;
                                                                                                                          
