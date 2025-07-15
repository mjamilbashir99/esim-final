<?php

namespace Modules\Hotels\Controllers;

use App\Controllers\BaseController;
use Modules\Hotels\Models\UserModel;
use App\Libraries\Template;


class ProfileController extends BaseController
{
    protected $userModel;
    protected $template;

    public function __construct()
    {
        $this->template = new Template();
        $this->userModel = new UserModel();
    }

    public function edit()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $userId = session()->get('user_id');

        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        return $this->template->render('Hotels/Views/profile/edit', ['user' => $user]);
    }

    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Please log in first.');
        }

        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'name'        => 'required',
            'dob'         => 'required|valid_date',
            'phone'       => 'required',
            'email'       => 'required|valid_email',
            'password'    => 'permit_empty|min_length[6]',
            'nationality' => 'required',
            'passport'    => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'         => $this->request->getPost('name'),
            'dob'          => $this->request->getPost('dob'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'nationality'  => $this->request->getPost('nationality'),
            'passport'     => $this->request->getPost('passport'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);

        session()->set([
            'user_name'  => $data['name'],
            'user_email' => $data['email'],
            'user_phone' => $data['phone'],
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

}
