import { useEffect, useState } from "react";

/**
 * 🌿 Page Admin - Liste des utilisateurs EcoRide
  * ------------------------------------------------
   * - Récupère les données via l’API PHP (MySQL)
    * - Affiche une table responsive
     * - Montre les erreurs et le chargement
      */
      export default function Users() {
        const [users, setUsers] = useState([]);
          const [loading, setLoading] = useState(true);
            const [error, setError] = useState(null);

              useEffect(() => {
                  fetch("http://localhost:8000/api/users.php")
                        .then((res) => res.json())
                              .then((data) => {
                                      if (data.status === "success") {
                                                setUsers(data.data);
                                                        } else {
                                                                  setError("Erreur de lecture de l’API");
                                                                          }
                                                                                  setLoading(false);
                                                                                        })
                                                                                              .catch((err) => {
                                                                                                      console.error("Erreur API:", err);
                                                                                                              setError("Impossible de se connecter à l’API");
                                                                                                                      setLoading(false);
                                                                                                                            });
                                                                                                                              }, []);

                                                                                                                                if (loading) {
                                                                                                                                    return <p className="text-center mt-10 text-gray-500">⏳ Chargement des utilisateurs...</p>;
                                                                                                                                      }

                                                                                                                                        if (error) {
                                                                                                                                            return <p className="text-center mt-10 text-red-600">❌ {error}</p>;
                                                                                                                                              }

                                                                                                                                                return (
                                                                                                                                                    <div className="p-6">
                                                                                                                                                          <h1 className="text-3xl font-bold text-green-600 mb-6 text-center">👥 Liste des utilisateurs EcoRide</h1>

                                                                                                                                                                <div className="overflow-x-auto">
                                                                                                                                                                        <table className="w-full border border-gray-200 rounded-lg shadow-md bg-white">
                                                                                                                                                                                  <thead>
                                                                                                                                                                                              <tr className="bg-green-100 text-gray-800">
                                                                                                                                                                                                            <th className="p-3 border">ID</th>
                                                                                                                                                                                                                          <th className="p-3 border">Nom</th>
                                                                                                                                                                                                                                        <th className="p-3 border">Email</th>
                                                                                                                                                                                                                                                      <th className="p-3 border">Rôle</th>
                                                                                                                                                                                                                                                                    <th className="p-3 border">Créé le</th>
                                                                                                                                                                                                                                                                                </tr>
                                                                                                                                                                                                                                                                                          </thead>
                                                                                                                                                                                                                                                                                                    <tbody>
                                                                                                                                                                                                                                                                                                                {users.map((u) => (
                                                                                                                                                                                                                                                                                                                              <tr key={u.id} className="hover:bg-green-50 transition">
                                                                                                                                                                                                                                                                                                                                              <td className="p-3 border text-center">{u.id}</td>
                                                                                                                                                                                                                                                                                                                                                              <td className="p-3 border">{u.name}</td>
                                                                                                                                                                                                                                                                                                                                                                              <td className="p-3 border">{u.email}</td>
                                                                                                                                                                                                                                                                                                                                                                                              <td className="p-3 border text-center font-semibold">{u.role}</td>
                                                                                                                                                                                                                                                                                                                                                                                                              <td className="p-3 border text-center text-sm text-gray-500">{u.created_at}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                            </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                        ))}
                                                                                                                                                                                                                                                                                                                                                                                                                                                  </tbody>
                                                                                                                                                                                                                                                                                                                                                                                                                                                          </table>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      );
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
