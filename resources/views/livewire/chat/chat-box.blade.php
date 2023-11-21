<div>
    @if ($selectedConversation)
        <div class="chat_box_header">
            <div class="return">
                <i class="fa-solid fa-arrow-left-long" wire:click="$emit('closeChat')"></i>
            </div>
            <div class="image_container">
                <img src="https://ui-avatars.com/api/?background=random&color=fff&name={{ $receiver->name }}"
                    alt="">
            </div>
            <div class="name">
                {{ $receiver->name }}
                <div class="status">
                    Online
                </div>
            </div>
            <div class="info">
                <div class="info_item">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="info_item">
                    <i class="fa-regular fa-image"></i>
                </div>
                <div class="info_item">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
            </div>
        </div>
        <div class="chat_box_body">

            @forelse ($messages as $msg)
                <div class="msg_body {{ $msg->sender_id == Auth::user()->id ? 'msg_body_me' : 'msg_body_reserver' }}">
                    {{ $msg->body }}
                    <div class="msg_footer">
                        <div class="date">
                            {{ $msg->created_at->format('m:i a') }}
                        </div>
                        <div class="read">
                            @if ($msg->sender_id == auth()->id())
                                <i
                                    class="fa-solid markRead {{ $msg->read == 1 ? 'fa-check-double text-primary' : 'fa-check' }} "></i>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

        </div>
        <div class="chat_box_footer"></div>
    @endif

    <script>
        window.addEventListener('rowChatToBottom', () => {
            $('.chat_box_body').scrollTop($('.chat_box_body')[0].scrollHeight);
        })

        $(document).on('click', '.goTop', function() {
            // $('.chat_box_body').scrollTop(0);
            $('.chat_box_body').animate({
                scrollTop: 0
            }, 'slow');

        })
    </script>

    <script>
        window.addEventListener('markMessageAsRead', () => {
            var value = document.querySelectorAll('.markRead');
            value.forEach((e) => {
                e.classList.remove("fa-check");
                e.classList.add('fa-check-double', 'text-primary');

            })
        })
    </script>
</div>
