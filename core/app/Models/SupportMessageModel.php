<?php

namespace App\Models;

use CodeIgniter\Model;

class SupportMessageModel extends Model
{
    protected $table = 'support_messages';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name', 'email', 'subject', 'message'];
    protected $useTimestamps = true;
}
