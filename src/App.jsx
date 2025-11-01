import { useEffect, useState } from "react";
import Header from "./components/Header";
import Footer from "./components/Footer";
import AppRouter from "./router/AppRouter";
import { AuthProvider } from "./context/AuthContext";
import { RidesProvider } from "./context/RidesContext";

function App() {
  const [backendStatus, setBackendStatus] = useState("⏳ Vérification du backend...");
  const [dbStatus, setDbStatus] = useState("⏳ Vérification de la base...");

  useEffect(() => {
    const API_BASE = import.meta.env.VITE_API_BASE_URL;

    // 🧩 Vérifier le backend
    fetch(`${API_BASE}/api/test`)
      .then((res) => res.json())
      .then((data) => {
        setBackendStatus(data?.status === "success" ? "✅ Backend Render connecté" : "⚠️ Backend répond mais inattendu");
      })
      .catch(() => setBackendStatus("❌ Backend Render inaccessible"));

    // 🧩 Vérifier la base PostgreSQL
    fetch(`${API_BASE}/api/db_status`)
      .then((res) => res.json())
      .then((data) => {
        setDbStatus(data?.status === "success" ? "✅ Base PostgreSQL OK" : "❌ Erreur de connexion DB");
      })
      .catch(() => setDbStatus("❌ Base PostgreSQL inaccessible"));
  }, []);

  return (
    <AuthProvider>
      <RidesProvider>
        <div className="flex flex-col min-h-screen bg-green-50">
          <Header />

          {/* 🟢 Bandeau de statut */}
          <div className="bg-green-100 text-green-800 text-center py-2 text-sm shadow-sm flex flex-col sm:flex-row sm:justify-center gap-2">
            <span>{backendStatus}</span>
            <span>•</span>
            <span>{dbStatus}</span>
          </div>

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

