<div
    x-data="{
        showConfirm: false,
        messageIdToDelete: null,
        confirmDelete(id) {
            this.messageIdToDelete = id;
            this.showConfirm = true;
        },
        cancelDelete() {
            this.showConfirm = false;
            this.messageIdToDelete = null;
        },
        deleteConfirmed() {
            $wire.deleteMessage(this.messageIdToDelete);
            this.cancelDelete();
        }
    }"
>






<div
    x-data="{ typingName: '', showTyping: false }"
    x-on:user-typing.window="
        typingName = $event.detail;
        showTyping = true;
        clearTimeout(window.typingTimeout);
        window.typingTimeout = setTimeout(() => showTyping = false, 2000);
    "
>
    <!-- Chat Messages -->
    <div class="h-96 overflow-y-scroll border p-4 mb-2 bg-white shadow rounded space-y-2">
        @foreach ($messages as $msg)
        <div class="relative p-2 rounded {{ $msg->user_id === auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100' }}">
            <p class="text-sm text-gray-600 font-semibold">
                {{ $msg->user->name }}
            </p>
            <p>{{ $msg->body }}</p>
    
            @if ($msg->user_id === auth()->id())
            <button @click="confirmDelete({{ $msg->id }})"
                    class="absolute top-1 right-1 text-xs text-red-500 hover:text-red-700">
                🗑
            </button>
        @endif
        
        </div>
    @endforeach
    
    </div>

    <!-- Typing Indicator -->
    <div x-show="showTyping" class="text-sm italic text-gray-500 mb-2">
        <span x-text="typingName"></span> is typing...
    </div>

    <!-- Message Input -->
    <form wire:submit.prevent="sendMessage" class="flex gap-2">
        <input type="text"
       wire:model.defer="message"
       wire:keydown="triggerTyping"
       class="w-full border p-2 rounded"
       placeholder="Type your message..."
       autofocus />


        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Send
        </button>
    </form>

    @error('message')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>


<!-- Delete Confirmation Modal -->
<div x-show="showConfirm"
     x-transition
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded shadow-xl text-center w-80">
        <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
        <p class="mb-4">Are you sure you want to delete this message?</p>
        <div class="flex justify-center gap-4">
            <button @click="deleteConfirmed"
                    class="bg-green-500 text-gray-800 px-4 py-2 rounded hover:bg-red-600">
                Delete
            </button>
            <button @click="cancelDelete"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                Cancel
            </button>
        </div>
    </div>
</div>
