import { Mail, Phone, MapPin, Send } from "lucide-react";
import { useState } from "react";

export default function Contact() {
  const [formData, setFormData] = useState({
    name: "",
    email: "",
    message: "",
  });

  const [status, setStatus] = useState(null); // "success" | "error" | null
  const [loading, setLoading] = useState(false);

  // 📦 Gestion du changement des champs
  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  // 📤 Soumission du formulaire vers l’API PHP
  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setStatus(null);

    try {
      const response = await fetch("http://localhost:8000/api/contact.php", {
        method: "POST",
        mode: "cors", // ✅ ajoute ce paramètre
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(formData),
      });

      const result = await response.json();

      if (result.success) {
        setStatus("success");
        setFormData({ name: "", email: "", message: "" });
      } else {
        setStatus("error");
      }
    } catch (error) {
      console.error("Erreur d’envoi :", error);
      setStatus("error");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="bg-green-50 min-h-screen py-10">
      <div className="container mx-auto px-4 max-w-4xl">
        {/* ===== TITRE ===== */}
        <h1 className="text-3xl font-bold text-green-700 mb-8 text-center">
          🌿 Contactez l’équipe EcoRide
        </h1>

        {/* ===== INFOS DE CONTACT ===== */}
        <div className="grid md:grid-cols-3 gap-6 mb-10 text-center">
          <div className="bg-white shadow rounded-xl p-6">
            <Mail className="mx-auto text-green-600 mb-2" size={28} />
            <h2 className="text-lg font-semibold">Email</h2>
            <p className="text-gray-600">contact@ecoride.com</p>
          </div>

          <div className="bg-white shadow rounded-xl p-6">
            <Phone className="mx-auto text-green-600 mb-2" size={28} />
            <h2 className="text-lg font-semibold">Téléphone</h2>
            <p className="text-gray-600">+33 6 00 00 00 00</p>
          </div>

          <div className="bg-white shadow rounded-xl p-6">
            <MapPin className="mx-auto text-green-600 mb-2" size={28} />
            <h2 className="text-lg font-semibold">Adresse</h2>
            <p className="text-gray-600">12 rue Verte, Paris 75000</p>
          </div>
        </div>

        {/* ===== FORMULAIRE ===== */}
        <form
          onSubmit={handleSubmit}
          className="bg-white shadow-md rounded-xl p-8 max-w-3xl mx-auto"
        >
          <h2 className="text-2xl font-semibold text-green-700 mb-6 text-center">
            📨 Envoyez-nous un message
          </h2>

          <div className="grid md:grid-cols-2 gap-4 mb-4">
            <input
              type="text"
              name="name"
              value={formData.name}
              onChange={handleChange}
              placeholder="Votre nom"
              required
              className="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-400"
            />
            <input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleChange}
              placeholder="Votre email"
              required
              className="border border-gray-300 rounded px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-green-400"
            />
          </div>

          <textarea
            name="message"
            value={formData.message}
            onChange={handleChange}
            placeholder="Votre message..."
            required
            rows="5"
            className="border border-gray-300 rounded px-3 py-2 w-full mb-4 focus:outline-none focus:ring-2 focus:ring-green-400"
          />

          <button
            type="submit"
            disabled={loading}
            className={`bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2 mx-auto ${
              loading ? "opacity-70 cursor-not-allowed" : ""
            }`}
          >
            <Send size={18} />
            {loading ? "Envoi en cours..." : "Envoyer le message"}
          </button>

          {/* ===== MESSAGE DE RETOUR ===== */}
          {status === "success" && (
            <p className="text-green-600 mt-4 text-center font-medium">
              ✅ Message envoyé avec succès !
            </p>
          )}
          {status === "error" && (
            <p className="text-red-600 mt-4 text-center font-medium">
              ❌ Erreur lors de l’envoi. Veuillez réessayer.
            </p>
          )}
        </form>
      </div>
    </div>
  );
}
