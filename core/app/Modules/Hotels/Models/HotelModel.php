<?php

namespace Modules\Hotels\Models;

use CodeIgniter\Model;

class HotelModel extends Model
{
    protected $table            = 'hotels';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    // protected $allowedFields    = ['hotel_code','name','country_code','destination_code','category','latitude','longitude','address','description','rating','thumbnail_url','amenities'];
    protected $allowedFields    = [
        'hotel_code',
        'name',
        'country_code',
        'destination_code',
        'category',
        'latitude',
        'longitude',
        'address',
        'description',
        'rating',
        'thumbnail_url',
        'state_code',
        'zone_code',
        'category_code',
        'created_at',
        'category_group_code',
        'chain_code',
        'accommodation_type_code',
        'board_codes',
        'segment_codes',
        'hotel_address',
        'postal_code',
        'city',
        'email',
        'license',
        'giata_code',
        'phones',
        'amenities'
    ];
    
    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
