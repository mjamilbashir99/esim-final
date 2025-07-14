<?php

namespace Modules\Esim\Controllers;

use App\Libraries\EsimTemplate;
use App\Controllers\BaseController;
use App\Models\SupportMessageModel;

class SupportController extends BaseController
{
    protected $template;

    public function __construct()
    {
        $this->template = new EsimTemplate();
    }

    public function index()
    {
        return $this->template->render('Esim/Views/support/index');
    }

    public function submit()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'name'    => 'required|min_length[3]',
            'email'   => 'required|valid_email',
            'subject' => 'required',
            'message' => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $model = new SupportMessageModel();

        $model->save([
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'subject' => $this->request->getPost('subject'),
            'message' => $this->request->getPost('message'),
        ]);

        return redirect()->back()->with('success', 'Your message has been submitted successfully!');
    }
}
