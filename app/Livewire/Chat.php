<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On; // <-- needed in Livewire 3
class Chat extends Component
{
    public $message;
    public $typing = false;
    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    public function sendMessage()
    {
        $this->validate();

        $msg = Message::create([
            'user_id' => Auth::id(),
            'body' => $this->message,
        ]);

        // Notify yourself for sound (sent)
        $this->dispatch('message-sent', id: $msg->id);

        // Notify others for sound (received)
        $this->dispatch('message-received', id: $msg->id)->self(false);

        $this->message = '';
    }

    public function triggerTyping()
    {
        $this->dispatch('user-typing', auth()->user()->name);
    }
    

    public function deleteMessage($id)
    {
        $message = Message::findOrFail($id);

        if ($message->user_id === auth()->id()) {
            $message->delete();
        }
    }

    public function render()
    {
        return view('livewire.chat', [
            'messages' => Message::with('user')->latest()->take(20)->get()->reverse(),
        ]);
    }
}