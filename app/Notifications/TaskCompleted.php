<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskCompleted extends Notification {
    public $message;
    public $url;

    public function __construct( $message, $url ) {
        $this->message = $message;
        $this->url = $url;
    }

    public function via( $notifiable ) {
        return [ 'mail', 'database' ];
        // Use mail and database notification channels
    }

    public function toMail( $notifiable ) {
        return ( new MailMessage )
        ->line( $this->message )
        ->action( 'View Task', $this->url )
        ->line( 'Thank you for using our application!' );
    }

    public function toDatabase( $notifiable ) {
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}
