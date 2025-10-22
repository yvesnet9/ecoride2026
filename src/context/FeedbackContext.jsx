import { createContext, useContext, useState } from "react";

/**
 * Contexte global pour gérer les feedbacks (avis et signalements)
  * envoyés par les passagers et consultés par les employés.
   */

   const FeedbackContext = createContext();

   export function FeedbackProvider({ children }) {
     const [feedbacks, setFeedbacks] = useState([
         // Exemple initial — simulera les premiers feedbacks
             {
                   id: 1,
                         ride: "Paris → Lyon",
                               passenger: "user@ecoride.fr",
                                     driver: "admin@ecoride.fr",
                                           rating: 4,
                                                 comment: "Super trajet, conducteur ponctuel !",
                                                       status: "pending",
                                                           },
                                                               {
                                                                     id: 2,
                                                                           ride: "Marseille → Nice",
                                                                                 passenger: "user@ecoride.fr",
                                                                                       driver: "admin@ecoride.fr",
                                                                                             rating: 2,
                                                                                                   comment: "Chauffeur en retard, trajet correct mais stressant.",
                                                                                                         status: "pending",
                                                                                                             },
                                                                                                               ]);

                                                                                                                 /** ➕ Ajouter un feedback (depuis l'espace passager) */
                                                                                                                   const addFeedback = (newFeedback) => {
                                                                                                                       setFeedbacks((prev) => [
                                                                                                                             ...prev,
                                                                                                                                   { id: Date.now(), status: "pending", ...newFeedback },
                                                                                                                                       ]);
                                                                                                                                         };

                                                                                                                                           /** 🔁 Mettre à jour un feedback (depuis l'espace employé) */
                                                                                                                                             const updateFeedbackStatus = (id, newStatus) => {
                                                                                                                                                 setFeedbacks((prev) =>
                                                                                                                                                       prev.map((fb) => (fb.id === id ? { ...fb, status: newStatus } : fb))
                                                                                                                                                           );
                                                                                                                                                             };

                                                                                                                                                               return (
                                                                                                                                                                   <FeedbackContext.Provider
                                                                                                                                                                         value={{
                                                                                                                                                                                 feedbacks,
                                                                                                                                                                                         addFeedback,
                                                                                                                                                                                                 updateFeedbackStatus,
                                                                                                                                                                                                       }}
                                                                                                                                                                                                           >
                                                                                                                                                                                                                 {children}
                                                                                                                                                                                                                     </FeedbackContext.Provider>
                                                                                                                                                                                                                       );
                                                                                                                                                                                                                       }

                                                                                                                                                                                                                       /** Hook personnalisé pour accéder facilement au contexte */
                                                                                                                                                                                                                       export const useFeedbacks = () => useContext(FeedbackContext);
                                                                                                                                                                                                                       
