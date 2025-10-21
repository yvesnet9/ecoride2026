import { BrowserRouter as Router } from "react-router-dom";
import Header from "./components/Header";
import Footer from "./components/Footer";
import AppRouter from "./router/AppRouter";

function App() {
  return (
      <Router>
            <div className="flex flex-col min-h-screen bg-green-50">
                    <Header />
                            <main className="flex-grow">
                                      <AppRouter />
                                              </main>
                                                      <Footer />
                                                            </div>
                                                                </Router>
                                                                  );
                                                                  }

                                                                  export default App;
                                                                  
