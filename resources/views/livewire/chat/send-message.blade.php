<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if ($selectedConversation)
        <form action="" wire:submit.prevent='sendMessage' id="send_message_form">
            <div class="chat_box_footer">
                <div class="custom_form_group">
                    <input type="text" class="control" id="message" placeholder="Message..." wire:model="body">
                    <button type="submit" class="submit">
                        {{-- <i class="fa-solid fa-paper-plane"></i> --}}
                        Send
                    </button>
                    {{-- <button class="goTop">
                        <i class="fa-solid fa-arrow-up"></i>
                    </button> --}}
                </div>
            </div>
        </form>
    @endif
</div>
