import { useRides } from "../context/RidesContext";
import RideFeedbackForm from "../components/RideFeedbackForm";

export default function PassengerRides() {
  const { rides } = useRides();
    const passengerEmail = "user@ecoride.fr";

      // On récupère uniquement les trajets terminés où ce passager est inscrit
        const ridesToValidate = rides.filter(
            (ride) =>
                  ride.status === "completed" && ride.passengers.includes(passengerEmail)
                    );

                      const handleFeedbackSubmit = (feedback) => {
                          console.log("📩 Feedback reçu :", feedback);

                              if (feedback.status === "ok") {
                                    alert("✅ Chauffeur crédité avec succès (simulation)");
                                        } else {
                                              alert("⚠️ Signalement envoyé à un employé (simulation)");
                                                  }
                                                    };

                                                      return (
                                                          <div className="max-w-3xl mx-auto mt-8">
                                                                <h2 className="text-2xl font-bold mb-4">Trajets à valider</h2>

                                                                      {ridesToValidate.length === 0 ? (
                                                                              <p className="text-gray-500">
                                                                                        Aucun trajet à valider pour le moment.
                                                                                                </p>
                                                                                                      ) : (
                                                                                                              ridesToValidate.map((ride) => (
                                                                                                                        <div key={ride.id} className="mb-4">
                                                                                                                                    <RideFeedbackForm
                                                                                                                                                  ride={ride}
                                                                                                                                                                onFeedbackSubmit={handleFeedbackSubmit}
                                                                                                                                                                            />
                                                                                                                                                                                      </div>
                                                                                                                                                                                              ))
                                                                                                                                                                                                    )}
                                                                                                                                                                                                        </div>
                                                                                                                                                                                                          );
                                                                                                                                                                                                          }
                                                                                                                                                                                                          
