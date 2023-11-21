<div>
    {{-- The whole world belongs to you. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="chat_container">
        <div class="chat_list_container">
            @livewire('chat.chat-list')
        </div>
        <div class="chat_box_container">
            @livewire('chat.chat-box')
            @livewire('chat.send-message')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            window.livewire.emit('resetList');
            $(".chat_list_container").show();
            $(".chat_box_container").hide();
        })
        window.addEventListener('chatSelected', (e) => {
            if (window.innerWidth < 767) {

                $(".chat_list_container").hide();
                $(".chat_box_container").show();
                $(".chat_box_container").css('width', '100% ');

            } else {

                $(".chat_box_container").show();
                $(".chat_list_container").show();
            }

            // Scroll Bottom auto when select conversation
            $('.chat_box_body').scrollTop($('.chat_box_body')[0].scrollHeight);
        });

        $(window).resize(function() {
            if (window.innerWidth > 768) {
                $(".chat_list_container").show();
                $(".chat_box_container").show();
            } else {
                window.livewire.emit('resetList');
                $(".chat_list_container").show();
                $(".chat_box_container").hide();
            }
        })

        $(document).on('click', '.return', function() {
            window.livewire.emit('resetList');
            $(".chat_list_container").show();
            $(".chat_box_container").hide();
        })

        document.addEventListener('keydown', function(event) {
            // Check if the pressed key is the Escape key
            if (event.key === 'Escape' || event.keyCode === 27) {
                // Your code to execute when the Escape key is pressed
                window.livewire.emit('resetList');
                $(".chat_list_container").show();
                $(".chat_box_container").hide();
            }
        });
    </script>
</div>
