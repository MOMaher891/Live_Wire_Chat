<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
    public $conversations;
    public $auth_id;
    public $receiver;
    public $selectedConversation;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetList'];

    public function refresh()
    {
    }

    public function resetList()
    {
        $this->selectedConversation = null;
        $this->receiver = null;
    }

    public function chatUserSelected(Conversation $conversation, $receiver_id)
    {
        $this->selectedConversation = $conversation;
        $receiverInstance = User::find($receiver_id);
        $this->emitTo('chat.chat-box', 'loadConversation', $this->selectedConversation, $receiverInstance);
        $this->emitTo('chat.send-message', 'updateSendMessage', $this->selectedConversation, $receiverInstance);
    }
    public function getChatUserInstance(Conversation $conversation, $request)
    {
        $this->auth_id = auth()->id();
        if ($conversation->sender_id == $this->auth_id) {
            $this->receiver = User::firstWhere('id', $conversation->receiver_id);
        } else {
            $this->receiver = User::firstWhere('id', $conversation->sender_id);
        }

        if (isset($request)) {
            return $this->receiver->$request;
        }
    }
    public function mount()
    {
        $this->auth_id = auth()->id();
        $this->conversations = Conversation::with('message')
            ->where('sender_id', $this->auth_id)
            ->orWhere('receiver_id', $this->auth_id)
            ->orderBy('last_time_message', "DESC")
            ->get();
        $this->emitTo('chat.chat-list', 'refresh');
    }
    public function render()
    {
        return view('livewire.chat.chat-list');
    }
}
