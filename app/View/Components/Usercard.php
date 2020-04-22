<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Usercard extends Component
{
    public $class;
    public $bgimage;
    public $userimg;
    public $name;
    public $email;
    public $description;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class, $bgimage, $userimg, $name, $email, $description)
    {
        $this->class = $class;
        $this->bgimage = $bgimage;
        $this->userimg = $userimg;
        $this->name = $name;
        $this->email = $email;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.usercard');
    }
}
