import { useEffect, useState } from "react";
import { Mail, User, Calendar, MessageSquare } from "lucide-react";
import FadePage from "../components/FadePage";

export default function AdminMessages() {
  const [messages, setMessages] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  // 🔁 Récupération des messages depuis MySQL
  useEffect(() => {
    const fetchMessages = async () => {
      try {
        const response = await fetch(
          "http://localhost:8000/api/contact.php?all=1"
        );
        const data = await response.json();

        if (!data.success) {
          throw new Error(data.error || "Erreur de récupération");
        }

        setMessages(data.messages || []);
      } catch (err) {
        console.error("Erreur :", err);
        setError("Impossible de récupérer les messages.");
      } finally {
        setLoading(false);
      }
    };

    fetchMessages();
  }, []);

  return (
    <FadePage>
      <div className="min-h-[85vh] bg-green-50 py-10">
        <div className="container mx-auto px-4">
          <h1 className="text-3xl font-bold text-green-700 mb-6 text-center">
            💌 Messages reçus via le site
          </h1>

          {/* === LOADER / ERREUR === */}
          {loading && (
            <p className="text-center text-gray-500">
              Chargement des messages...
            </p>
          )}
          {error && (
            <p className="text-center text-red-600 font-semibold">{error}</p>
          )}

          {/* === AUCUN MESSAGE === */}
          {!loading && messages.length === 0 && (
            <p className="text-center text-gray-500 italic">
              Aucun message pour le moment.
            </p>
          )}

          {/* === LISTE DES MESSAGES === */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            {messages.map((msg) => (
              <div
                key={msg.id}
                className="bg-white p-6 rounded-xl shadow hover:shadow-lg transition-all duration-300"
              >
                <div className="flex items-center justify-between mb-3">
                  <h2 className="text-lg font-semibold text-green-700 flex items-center gap-2">
                    <User size={18} /> {msg.name}
                  </h2>
                  <span className="text-sm text-gray-500 flex items-center gap-1">
                    <Calendar size={14} />{" "}
                    {new Date(msg.created_at).toLocaleDateString()}
                  </span>
                </div>
                <p className="text-gray-600 text-sm mb-2 flex items-center gap-2">
                  <Mail size={16} /> {msg.email}
                </p>
                <div className="mt-3 bg-green-50 p-3 rounded-lg border border-green-100">
                  <p className="text-gray-700 text-sm flex items-start gap-2">
                    <MessageSquare size={16} className="mt-1" /> {msg.message}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </FadePage>
  );
}
