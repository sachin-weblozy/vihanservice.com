<div class="prebody">
    <div class="body px-5" id="chat-container">
        @forelse($comments as $comment)
            @if($comment->user_id != Auth::id())
            <div class="incoming">
                <p><span class="mdi mdi-1px mdi-account-circle"></span> <span class="font-italic"><small>{{ $comment->user->name }}</small></span></p>
                <div class="bubble">
                    <p>{{ $comment->message }}</p>
                </div>
            </div>
            @endif
            @if($comment->user_id == Auth::id())
            <div class="outgoing">
                <div class="bubble lower">
                    <p>{{ $comment->message }}</p>
                </div>
            </div>
            @endif
        @empty 
        <p class="text-center">No message found</p>
        @endforelse
    </div>

    <form wire:submit.prevent="sendMessage">
        <div class="foot pt-2">
            <input type="text" wire:model="newMessage" class="msg" placeholder="Type a message..." />
            <button type="submit"><i class="fas fa-paper-plane"></i></button>
        </div>
    </form>

    <script>
        // Function to scroll to the bottom of the chat container
        function scrollToBottom() {
            var chatContainer = document.getElementById('chat-container');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        document.addEventListener('livewire:load', function () {
            Livewire.on('scrollToBottom', function () {
                scrollToBottom();
            });
        });

        window.addEventListener('sendMessage', e => {
            updateChat();
        });

        function updateChat() {
            scrollToBottom();
        }

        window.onload = function() {
            scrollToBottom();
        };
    </script>
</div>
