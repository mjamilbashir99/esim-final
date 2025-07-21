<?php
namespace App\Libraries;

class AdminTemplate
{
    protected $layout = 'Admin/Views/admin_default';

    public function render($view, $data = [])
    {
        $data['content'] = view($view, $data);
        return view($this->layout, $data);
    }
}
