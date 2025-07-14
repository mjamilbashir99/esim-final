<?php

namespace Modules\Blog\Controllers;

use App\Controllers\BaseController;
use Modules\Blog\Models\BlogModel;

class BlogController extends BaseController
{
    public function index()
    {
        $model = new BlogModel();
        $data['blogs'] = $model->getBlogs();

        return view('Blog/Views/index'); 
    }
}
