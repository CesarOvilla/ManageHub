<?php

declare(strict_types=1);

namespace App\Livewire\Ui;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class QuillTextEditor extends Component
{
    #[Modelable]
    public string | null $value = '';

    #[Locked]
    public string $quillId;

    public string $theme;

    public $readOnly = false;

    public function mount(string $theme = 'snow'): void
    {
        $this->theme = $theme;
        $this->quillId = 'ql-editor-'.Str::uuid()->toString();
    }

    public function updatedValue($value): void
    {
        $this->value = $value;
    }

    public function render()
    {
        return view('livewire.ui.quill-text-editor');
    }
}
