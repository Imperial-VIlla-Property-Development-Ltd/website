<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use App\Models\Document;

class ClientDocumentUploaded extends Notification implements ShouldQueue
{
    use Queueable;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $client = $this->document->client;
        return [
            'title' => 'New Document Uploaded',
            'message' => "{$client->firstname} {$client->lastname} uploaded a new document: {$this->document->title}",
            'document_id' => $this->document->id,
            'client_id' => $client->id,
        ];
    }
}
