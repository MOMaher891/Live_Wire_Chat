<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="chat_list_header">
        <div class="title">
            {{-- {{ Auth::user()->name }} --}}
            Chats
        </div>
        <div class="image_container">
            <img src="https://ui-avatars.com/api/?background=0D8ABC&color=fff&name={{ Auth::user()->name }}"
                alt="">
            {{-- <img src="https://picsum.photos/id/237/200/300" alt=""> --}}
        </div>
    </div>
    <div class="chat_list_body">
        @forelse ($conversations as $item)
            <div class="chat_list_item" wire:key='{{ $item->id }}'
                wire:click="$emit('chatUserSelected',{{ $item }},{{ $this->getChatUserInstance($item, 'id') }})">
                <div class="chat_list_image_container">

                    <img src="https://ui-avatars.com/api/?background=random&color=fff&name={{ $this->getChatUserInstance($item, 'name') }}"
                        alt="">
                    {{-- <img src="https://picsum.photos/id/{{$this->getChatUserInstance($item,'id')}}/200/300" alt=""> --}}
                </div>
                <div class="chat_list_info">
                    <div class="top_tow">
                        <div class="list_username">{{ $this->getChatUserInstance($item, 'name') }}</div>
                        @if ($item->message->last())
                            <span
                                class="date">{{ $item->message->last()->created_at->shortAbsoluteDiffForHumans() }}</span>
                        @else
                            <span class="date"></span>
                        @endif
                    </div>
                    <div class="bottom_row">
                        <div class="message_body text-truncate">
                            {{ optional($item->message->last())->body }}
                        </div>
                        @php
                            $unReadedMessagesCount = count($item->message->where('read', 0)->where('receiver_id', auth()->id()));
                            if ($unReadedMessagesCount) {
                                echo '<div class="unread_count badge rounded-pill text-light bg-danger">' . $unReadedMessagesCount . '</div>';
                            }
                        @endphp
                    </div>
                </div>
            </div>
        @empty
            <span class="text-danger">You Have No Conversations</span>
        @endforelse




    </div>
</div>
