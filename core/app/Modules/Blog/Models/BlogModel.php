<?php

namespace Modules\Blog\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs';

    public function getBlogs()
    {
        return $this->findAll();
    }
}
