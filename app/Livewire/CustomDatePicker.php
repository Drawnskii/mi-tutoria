<?php

namespace App\Livewire;

use Livewire\Component;

class CustomDatepicker extends Component
{
    public $name;
    public $label;
    public $value;
    public $showPicker = false;
    public $displayValue;

    public function mount($name, $label, $value = '', $format = 'YYYY-MM-DD')
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->displayValue = $value ? date('d/m/Y', strtotime($value)) : '';
    }

    public function selectDate($date)
    {
        $this->value = $date;
        $this->displayValue = date('d/m/Y', strtotime($date));
        $this->showPicker = false;
    }

    public function render()
    {
        return view('livewire.custom-date-picker');
    }
}