<?php

namespace App\Http\Livewire\Chat;

use App\Events\MessageRead;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $receiver;
    public $message_count;
    public $paginateVat;
    public $messages;
    // protected $listeners = ['loadConversation', 'pushMessage'];

    public function getListeners()
    {
        $auth_id = auth()->user()->id;
        return [
            "echo-private:chat.{$auth_id},MessageSent" => "broadcastMessageReceived",
            "echo-private:chat.{$auth_id},MessageRead" => "broadcastedMessageRead",
            'loadConversation', 'pushMessage', 'refresh' => '$refresh', 'broadcastMessageRead', 'resetList'
        ];
    }

    public function resetList()
    {
        $this->selectedConversation = null;
        $this->receiver = null;
    }
    public function broadcastedMessageRead($event)
    {
        // dd($event);
        if ($this->selectedConversation && (int) $this->selectedConversation->id === (int) $event['conversation_id']) {
            $this->dispatchBrowserEvent('markMessageAsRead');
        }
    }
    public function broadcastMessageReceived($event)
    {
        $this->emitTo('chat.chat-list', 'refresh');
        $broadcastMessage = Message::find($event['message']);
        if ($this->selectedConversation && (int) $this->selectedConversation->id === (int) $event['conversation']) {
            // Make this message as read
            $broadcastMessage->update(['read' => 1]);
            $this->pushMessage($broadcastMessage->id);
            $this->emitTo('chat.chat-box', 'refresh');
            $this->emitSelf('broadcastMessageRead');
        }
    }


    public function broadcastMessageRead()
    {

        broadcast(new MessageRead($this->selectedConversation->id, $this->receiver->id));
    }


    public function pushMessage($messageId)
    {
        $new_message = Message::find($messageId);
        $this->messages->push($new_message);
        $this->dispatchBrowserEvent('rowChatToBottom');
        $this->emitTo('chat.chat-list', 'refresh');
    }
    public function loadConversation(Conversation $conversation, User $receiver)
    {
        $this->selectedConversation = $conversation;
        $this->receiver = $receiver;
        $this->message_count = Message::where('conversation_id', $this->selectedConversation->id)->count();
        $this->messages = Message::where('conversation_id', $this->selectedConversation->id)->get();
        Message::where('conversation_id', $this->selectedConversation->id)->where('receiver_id', auth()->id())->update(['read' => 1]);

        $this->dispatchBrowserEvent('chatSelected');
        $this->emitSelf('broadcastMessageRead');
    }


    public function closeChat()
    {
        $this->selectedConversation = null;
    }
    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
