import { Routes, Route } from "react-router-dom";

// --- Pages publiques ---
import Home from "../pages/Home.jsx";
import Rides from "../pages/Rides.jsx";
import RideDetail from "../pages/RideDetail.jsx";
import Contact from "../pages/Contact.jsx";
import Mentions from "../pages/Mentions.jsx";
import Login from "../pages/Login.jsx";
import Register from "../pages/Register.jsx";

// --- Espace utilisateur ---
import Profile from "../pages/Profile.jsx";
import ProfileRides from "../pages/ProfileRides.jsx";
import PassengerRides from "../pages/PassengerRides.jsx";

// --- Espace employé ---
import EmployeeDashboard from "../pages/EmployeeDashboard.jsx";

// --- Espace administrateur ---
import AdminLayout from "../layouts/AdminLayout.jsx";
import AdminDashboard from "../pages/AdminDashboard.jsx";
import Users from "../pages/Users.jsx";
import Logs from "../pages/Logs.jsx";
import AdminMessages from "../pages/AdminMessages.jsx";
import EmployeeManager from "../pages/EmployeeManager.jsx";
import Admin from "../pages/Admin.jsx";

// --- Routes protégées ---
import ProtectedAdminRoute from "../components/ProtectedAdminRoute.jsx";
import ProtectedEmployeeRoute from "../components/ProtectedEmployeeRoute.jsx";

/**
 * 🧭 AppRouter
 * -------------------------------------------------------
 * Gère la navigation complète de l'application EcoRide :
 * - Routes publiques (Home, Contact, etc.)
 * - Espace utilisateur
 * - Espace employé protégé
 * - Espace admin avec layout (Dashboard / Users / Logs / Messages)
 */
export default function AppRouter() {
  return (
    <Routes>
      {/* === 🌍 Pages publiques === */}
      <Route path="/" element={<Home />} />
      <Route path="/rides" element={<Rides />} />
      <Route path="/rides/:id" element={<RideDetail />} />
      <Route path="/contact" element={<Contact />} />
      <Route path="/mentions" element={<Mentions />} />
      <Route path="/login" element={<Login />} />
      <Route path="/register" element={<Register />} />

      {/* === 👤 Espace utilisateur === */}
      <Route path="/profile" element={<Profile />} />
      <Route path="/profile/rides" element={<ProfileRides />} />
      <Route path="/profile/passenger" element={<PassengerRides />} />

      {/* === 🧑‍💼 Espace employé protégé === */}
      <Route
        path="/employee/dashboard"
        element={
          <ProtectedEmployeeRoute>
            <EmployeeDashboard />
          </ProtectedEmployeeRoute>
        }
      />

      {/* === 🛠️ Espace administrateur avec layout === */}
      <Route
        path="/admin"
        element={
          <ProtectedAdminRoute>
            <AdminLayout />
          </ProtectedAdminRoute>
        }
      >
        {/* Sous-routes affichées dans <Outlet /> du layout */}
        <Route path="dashboard" element={<AdminDashboard />} />
        <Route path="users" element={<Users />} />
        <Route path="logs" element={<Logs />} />
        <Route path="messages" element={<AdminMessages />} />
        <Route path="employees" element={<EmployeeManager />} />
        <Route index element={<AdminDashboard />} />
      </Route>

      {/* --- 🚫 Page 404 --- */}
      <Route
        path="*"
        element={
          <h1 className="text-center mt-10 text-red-600 text-2xl">
            404 - Page non trouvée
          </h1>
        }
      />
    </Routes>
  );
}
