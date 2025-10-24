import { useState } from "react";
import { Link, Outlet, useLocation } from "react-router-dom";
import {
  Menu,
  X,
  LayoutDashboard,
  Users,
  List,
  Mail,
  LogOut,
} from "lucide-react";

/**
 * 🌿 AdminLayout.jsx
 * Layout principal de l’espace administrateur EcoRide
 * - Sidebar fixe sur desktop
 * - Menu burger responsive sur mobile
 * - Navigation entre Dashboard / Users / Logs / Messages
 */
export default function AdminLayout() {
  const [isOpen, setIsOpen] = useState(false);
  const location = useLocation();

  const toggleMenu = () => setIsOpen(!isOpen);
  const closeMenu = () => setIsOpen(false);

  const navLinks = [
    {
      to: "/admin/dashboard",
      icon: <LayoutDashboard size={18} />,
      label: "Tableau de bord",
    },
    { to: "/admin/users", icon: <Users size={18} />, label: "Utilisateurs" },
    { to: "/admin/logs", icon: <List size={18} />, label: "Logs" },
    { to: "/admin/messages", icon: <Mail size={18} />, label: "Messages" },
  ];

  return (
    <div className="flex min-h-screen bg-green-50">
      {/* === SIDEBAR (Desktop) === */}
      <aside className="hidden md:flex flex-col w-64 bg-white shadow-lg p-6">
        <h2 className="text-2xl font-bold text-green-700 mb-8">
          EcoRide Admin
        </h2>
        <nav className="space-y-4">
          {navLinks.map((link) => (
            <Link
              key={link.to}
              to={link.to}
              onClick={closeMenu}
              className={`flex items-center gap-2 p-2 rounded-lg transition ${
                location.pathname === link.to
                  ? "bg-green-100 text-green-700 font-semibold"
                  : "text-gray-700 hover:bg-green-50 hover:text-green-600"
              }`}
            >
              {link.icon}
              {link.label}
            </Link>
          ))}
        </nav>

        <div className="mt-auto pt-6 border-t">
          <button className="flex items-center gap-2 text-red-600 hover:text-red-700">
            <LogOut size={18} /> Déconnexion
          </button>
        </div>
      </aside>

      {/* === MENU BURGER (Mobile) === */}
      <div className="md:hidden fixed top-4 left-4 z-50">
        <button
          onClick={toggleMenu}
          className="bg-green-600 text-white p-2 rounded-lg shadow"
        >
          {isOpen ? <X size={24} /> : <Menu size={24} />}
        </button>
      </div>

      {/* === MENU MOBILE (overlay) === */}
      {isOpen && (
        <div
          className="fixed inset-0 bg-black bg-opacity-40 z-40"
          onClick={closeMenu}
        >
          <div
            className="absolute top-0 left-0 w-64 bg-white h-full p-6 shadow-lg"
            onClick={(e) => e.stopPropagation()}
          >
            <h2 className="text-xl font-bold text-green-700 mb-6">
              EcoRide Admin
            </h2>
            <nav className="space-y-4">
              {navLinks.map((link) => (
                <Link
                  key={link.to}
                  to={link.to}
                  onClick={closeMenu}
                  className={`flex items-center gap-2 p-2 rounded-lg transition ${
                    location.pathname === link.to
                      ? "bg-green-100 text-green-700 font-semibold"
                      : "text-gray-700 hover:bg-green-50 hover:text-green-600"
                  }`}
                >
                  {link.icon}
                  {link.label}
                </Link>
              ))}
            </nav>
          </div>
        </div>
      )}

      {/* === CONTENU PRINCIPAL === */}
      <main className="flex-1 p-6 md:ml-64">
        <Outlet />
      </main>
    </div>
  );
}
