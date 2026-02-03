<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FinancialCard extends Component
{
    public $title;
    public $amount;
    public $subtitle;
    public $trend;
    public $color;

    public function __construct($title, $amount, $subtitle = null, $trend = null, $color = 'green')
    {
        $this->title = $title;
        $this->amount = $amount;
        $this->subtitle = $subtitle;
        $this->trend = $trend;
        $this->color = $color;
    }

    public function render()
    {
        return view('components.financial-card');
    }
}