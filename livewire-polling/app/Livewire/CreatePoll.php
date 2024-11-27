<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class CreatePoll extends Component
{
    public string $title;
    public array $options;

    /**
     * @return Factory|View|Application|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    // public function mount()
    // {
    //
    // }
}
