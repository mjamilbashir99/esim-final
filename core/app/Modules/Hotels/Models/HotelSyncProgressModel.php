<?php

namespace Modules\Hotels\Models;

use CodeIgniter\Model;

class HotelSyncProgressModel extends Model
{
    protected $table      = 'hotel_sync_progress';
    protected $primaryKey = 'id';
    protected $allowedFields = ['last_to'];
}
