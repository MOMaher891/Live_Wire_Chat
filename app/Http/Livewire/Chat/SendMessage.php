<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class SendMessage extends Component
{
    public $receiver;
    public $selectedConversation;
    public $body;
    public $createMessage;
    protected $listeners = ['updateSendMessage', 'MessageSentEvent', 'resetList'];



    public function resetList()
    {
        $this->selectedConversation = null;
        $this->receiver = null;
    }
    public function updateSendMessage(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
    }

    public function sendMessage()
    {
        if ($this->body == null) {
            return null;
        }
        $this->createMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'receiver_id' => $this->receiver->id,
            'body' => $this->body,
            'sender_id' => auth()->id(),
        ]);
        $this->selectedConversation->last_time_message = $this->createMessage->created_at;
        $this->selectedConversation->save();

        $this->emitTo('chat.chat-box', 'pushMessage', $this->createMessage->id);
        $this->emitTo('chat.chat-list', 'refresh');
        $this->reset('body');
        $this->emitSelf('MessageSentEvent');
    }

    public function MessageSentEvent()
    {
        broadcast(new MessageSent(Auth()->user(), $this->selectedConversation, $this->createMessage, $this->receiver));
    }

    public function render()
    {
        return view('livewire.chat.send-message');
    }
}
