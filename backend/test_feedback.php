<?php
require 'models/FeedbackModel.php';

$feedback = new FeedbackModel();
$result = $feedback->createFeedback("RID123", "user@ecoride.fr", 5, "Trajet parfait !");
print_r($result);
