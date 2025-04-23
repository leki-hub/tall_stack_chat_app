<div>
    <!-- Message List -->
    <div class="h-96 overflow-y-scroll border p-4 mb-2 bg-white shadow rounded space-y-2">
        @foreach ($messages as $msg)
            <div class="p-2 rounded {{ $msg->user_id === auth()->id() ? 'bg-blue-100 text-right' : 'bg-gray-100' }}">
                <p class="text-sm text-gray-600 font-semibold">
                    {{ $msg->user->name }}
                </p>
                <p>{{ $msg->body }}</p>
            </div>
        @endforeach
    </div>

    <!-- Message Input Form -->
    <form wire:submit.prevent="sendMessage" class="flex gap-2">
        <input type="text" wire:model.defer="message"
               class="w-full border p-2 rounded" placeholder="Type your message..." autofocus />
        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Send
        </button>
    </form>

    @error('message')
        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
    @enderror
</div>
