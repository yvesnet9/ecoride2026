<?php
/**
 * ======================================================
 *  EcoRide 2026 - FeedbackModel
 * ------------------------------------------------------
 *  Gère les avis (feedbacks) des covoiturages.
 *  Stockés dans MongoDB pour flexibilité et rapidité.
 *  Inclut : création, lecture, validation et logs.
 * ======================================================
 */

require_once __DIR__ . '/../config/db_mongo.php';

class FeedbackModel {
    private $collection;
    private $logs;

    public function __construct() {
        $mongo = new MongoConnection();
        $db = $mongo->getDatabase();
        $this->collection = $db->feedbacks;
        $this->logs = $db->logs;
    }

    /**
     * ✅ Créer un nouvel avis
     * @param string $rideId
     * @param string $passengerEmail
     * @param int $rating
     * @param string $comment
     * @return array
     */
    public function createFeedback($rideId, $passengerEmail, $rating, $comment) {
        $data = [
            'ride_id' => $rideId,
            'passenger_email' => $passengerEmail,
            'rating' => (int) $rating,
            'comment' => $comment,
            'validated' => false,
            'created_at' => new MongoDB\BSON\UTCDateTime(),
        ];
        $result = $this->collection->insertOne($data);

        $this->logAction("Création d'un feedback par $passengerEmail pour le trajet $rideId");

        return [
            'success' => true,
            'inserted_id' => (string) $result->getInsertedId()
        ];
    }

    /**
     * 📋 Récupérer tous les avis (optionnel : filtrés)
     * @param bool|null $validated
     * @return array
     */
    public function getAllFeedbacks($validated = null) {
        $filter = [];
        if ($validated !== null) {
            $filter['validated'] = (bool) $validated;
        }
        $cursor = $this->collection->find($filter);
        return iterator_to_array($cursor);
    }

    /**
     * 🔍 Récupérer un avis spécifique
     * @param string $id
     * @return array|null
     */
    public function getFeedbackById($id) {
        return $this->collection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    }

    /**
     * 🧾 Valider un feedback
     * (Utilisé par un employé dans l’espace de validation)
     * @param string $id
     * @param string $validatorEmail
     * @return bool
     */
    public function validateFeedback($id, $validatorEmail) {
        $result = $this->collection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($id)],
            ['$set' => ['validated' => true, 'validated_by' => $validatorEmail]]
        );

        if ($result->getModifiedCount() > 0) {
            $this->logAction("Validation de l'avis $id par $validatorEmail");
            return true;
        }
        return false;
    }

    /**
     * ❌ Supprimer un feedback
     * @param string $id
     * @param string $actor
     * @return bool
     */
    public function deleteFeedback($id, $actor) {
        $result = $this->collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
        if ($result->getDeletedCount() > 0) {
            $this->logAction("Suppression de l'avis $id par $actor");
            return true;
        }
        return false;
    }

    /**
     * 🧠 Journaliser une action dans MongoDB
     * @param string $message
     */
    private function logAction($message) {
        $this->logs->insertOne([
            'message' => $message,
            'timestamp' => new MongoDB\BSON\UTCDateTime()
        ]);
    }
}
