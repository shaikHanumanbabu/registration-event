<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationSuccessMail extends Mailable
{
  use Queueable, SerializesModels;

  public $registration;
  public $qrCodePath;

  /**
   * Create a new message instance.
   */
  public function __construct($registration, $qrCodePath = null)
  {
    $this->registration = $registration;
    $this->qrCodePath = $qrCodePath;
  }

  /**
   * Get the message envelope.
   */
  public function envelope()
  {
    return new \Illuminate\Mail\Mailables\Envelope(
      subject: 'Event Registration Successful - ' . config('app.name')
    );
  }

  /**
   * Get the message content definition.
   */
  public function content()
  {
    return new \Illuminate\Mail\Mailables\Content(
      view: 'emails.registration-success'
    );
  }

  /**
   * Get the attachments for the message.
   */
  public function attachments()
  {
    return [];
  }
}
