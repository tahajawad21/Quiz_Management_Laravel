<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\StudentSubmission;

class StudentSubmissionStatus extends Mailable
{
    use Queueable, SerializesModels;

    public $submission; // Holds the submission object
    public $customMessage;
    /**
     * Create a new message instance.
     *
     * @param StudentSubmission $submission
     * @return void
     */
    public function __construct(StudentSubmission $submission, $customMessage = null)
    {
        $this->submission = $submission;
        $this->customMessage = $customMessage;
    }
    

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.submission-status') // Reference the Blade template
                    ->with(['submission' => $this->submission]); // Pass the object to the view
    }
}
