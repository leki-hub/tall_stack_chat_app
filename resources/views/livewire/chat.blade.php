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
            <div class="p-2 rounded {{ $msg->user_id === auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100' }}">
                <p class="text-sm text-gray-600 font-semibold">{{ $msg->user->name }}</p>
                <p>{{ $msg->body }}</p>
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
