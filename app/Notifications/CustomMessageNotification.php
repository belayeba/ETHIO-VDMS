<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;  // Import the Str helper for UUID generation

class CustomMessageNotification extends Notification
{
    use Queueable;

    protected $messageContent;
    protected $subject;
    protected $url;
    protected $user;

    // Constructor to initialize the notification data
    public function __construct($messageContent,$subject = null, $url = null)
    {
        $this->messageContent = $messageContent;
        $this->subject = $subject ?? 'No Subject';
        $this->url = $url ?? url('/');
    }

    // We're not using the default database channel, so override the `via` method
    public function via($notifiable)
    {
        return [];
    }

    // Manually store the notification in your custom notifications table
    public function storeInCustomTable($notifiable)
    {
        // Insert only the necessary fields into the notifications table
        return DB::table('notifications')->insert([
            'notification_id' => (string) Str::uuid(),  // Generate a UUID
            'user_id' => $notifiable->id,  // Insert the user ID
            'subject' => $this->subject,  // Insert the notification subject
            'message' => $this->messageContent,  // Insert the message content
            'url'     => $this->url,  // Insert the URL
            'is_read' => false,  // Set is_read to false by default
            'created_at' => now(),  // Insert the current timestamp for created_at
            'updated_at' => now(),  // Insert the current timestamp for updated_at
        ]);
    }
}
