<?php
declare(strict_types=1);

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component {



    /**
     * Create a new component instance.
     */
    public function __construct(public string $type, public string $name, public string $placeholder, public string $class, public ?string $label = null) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
