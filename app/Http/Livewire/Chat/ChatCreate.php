<?php

namespace App\Http\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ChatCreate extends Component
{
    public $users;
    public function render()
    {
        /**
         * This Query Get Un-order Data
         */
        $this->users = DB::table('users')
            ->where('id', '!=', auth()->user()->id)
            ->orderByRaw('RAND()')
            ->get();
        return view('livewire.chat.chat-create');
    }

    public function checkConversation($receiverId)
    {
        /**
         * IN This function There are some processes
         * ------------------------------------------
         * 1) Make check if there are conversation between sender and receiver ..
         * 2) If not conversation :
         *    --------------------
         *      1->create new conversation
         *      2->create new message
         *      3->set last_time_message in conversation = message->created_at
         * 3) If there are conversation
         */

        try {
            $sender_id = auth()->user()->id;
            $conversation = Conversation::where('sender_id', $sender_id)
                ->where('receiver_id', $receiverId)
                ->orWhere('sender_id', $receiverId)
                ->where('receiver_id', $sender_id)
                ->exists();
            if ($conversation) {
                dd('there are conversation');
            } else {
                DB::beginTransaction();
                $conversation_created = Conversation::create([
                    "sender_id" => $sender_id,
                    "receiver_id" => $receiverId,
                ]);
                // $message_created = Message::create([
                //     "body" => "",
                //     "conversation_id" => $conversation_created->id,
                //     "is_read" => 0,
                //     "sender_id" => $sender_id,
                //     "receiver_id" => $receiverId,
                // ]);
                // $conversation_created->update(['last_time_message' => $message_created->created_at]);
                DB::commit();
                dd('Conversation Created Successfully');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new \Exception("Error Processing Request", 1);
        }
    }
}
