<?php

namespace App\Helpers;

class MessageHelper
{
    public static function formatSubmissionMessage($status, $customMessage = null)
    {
        $defaultMessages = [
            'accepted' => 'Your submission has been accepted.',
            'rejected' => 'Unfortunately, your submission has been rejected.',
            'pending' => 'Your submission status is pending.',
        ];

        // If custom message is provided, use it, otherwise fallback to the default message
        return $customMessage ?? ($defaultMessages[$status] ?? 'Your submission status has been updated.');
    }
}
