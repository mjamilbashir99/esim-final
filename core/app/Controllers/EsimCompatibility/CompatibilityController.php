<?php

namespace App\Controllers\EsimCompatibility;

use App\Libraries\EsimTemplate;
use CodeIgniter\Controller;

class CompatibilityController extends Controller
{
    protected $template;

    public function __construct()
    {
        $this->template = new EsimTemplate();
    }

    public function show($brand)
    {
        $validBrands = ['apple', 'samsung', 'oppo', 'huawei', 'laptop', 'google', 'other'];
        if (!in_array($brand, $validBrands)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $recent = session()->get('recent_views') ?? [];
        $recent = array_filter($recent, fn($item) => $item !== $brand);
        array_unshift($recent, $brand);
        $recent = array_slice($recent, 0, 5);

        session()->set('recent_views', $recent);

        return view('compatibility/' . $brand);
    }

    private function trackView($brand)
    {
        $recent = session()->get('recent_views') ?? [];
        $recent = array_filter($recent, fn($item) => $item !== $brand);
        array_unshift($recent, $brand);
        $recent = array_slice($recent, 0, 5);
        session()->set('recent_views', $recent);
    }



    public function index()
    {
        return $this->template->render('compatibility/index');
    }

    public function apple()
    {
        $this->trackView('apple');
        return $this->template->render('compatibility/apple');
    }

    public function google()
    {
        $this->trackView('google');
        return $this->template->render('compatibility/google');
    }

    public function samsung()
    {
        $this->trackView('samsung');
        return $this->template->render('compatibility/samsung');
    }

    public function huawei()
    {
        $this->trackView('huawei');
        return $this->template->render('compatibility/huawei');
    }

    public function laptop()
    {
        $this->trackView('laptop');

        return $this->template->render('compatibility/laptop');
    }

    public function oppo()
    {
        $this->trackView('oppo');
        return $this->template->render('compatibility/oppo');
    }

    public function other()
    {
        $this->trackView('other');
        return $this->template->render('compatibility/other');
    }
}
