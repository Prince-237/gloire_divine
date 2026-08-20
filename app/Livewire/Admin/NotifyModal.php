<?php

namespace App\Livewire\Admin;

use App\Models\NotificationLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class NotifyModal extends Component
{
    public Model $notifiable;

    public bool $showModal = false;
    public bool $selectAll = false;
    public array $selected = [];
    public bool $justSent = false;

    public function mount(Model $notifiable): void
    {
        $this->notifiable = $notifiable;
    }

    public function getPatientsProperty()
    {
        return User::where('role', 'patient')
            ->where('whatsapp_opt_in', true)
            ->whereNotNull('phone')
            ->orderBy('name')
            ->get();
    }

    public function updatedSelectAll(bool $value): void
    {
        $this->selected = $value ? $this->patients->pluck('id')->map(fn ($id) => (string) $id)->toArray() : [];
    }

    public function updatedSelected(): void
    {
        $this->selectAll = count($this->selected) === $this->patients->count();
    }

    public function send(): void
    {
        $this->validate([
            'selected' => ['required', 'array', 'min:1'],
        ], [
            'selected.required' => 'Sélectionnez au moins un destinataire.',
        ]);

        foreach ($this->selected as $userId) {
            NotificationLog::create([
                'notifiable_type' => get_class($this->notifiable),
                'notifiable_id' => $this->notifiable->id,
                'user_id' => $userId,
                'channel' => 'whatsapp',
                'status' => 'en_attente', // TODO (Phase 8) : branché sur l'API WhatsApp réelle.
            ]);
        }

        $this->justSent = true;
        $this->selected = [];
        $this->selectAll = false;
    }

    public function render()
    {
        return view('livewire.admin.notify-modal');
    }
}
