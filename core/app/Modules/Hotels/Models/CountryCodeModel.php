<?php

namespace Modules\Hotels\Models;

use CodeIgniter\Model;

class CountryCodeModel extends Model
{
    protected $table = 'countries';


    public function getCountryCodes(){
        $countryCodeModel = new CountryCodeModel();
        $query = $countryCodeModel->where('phonecode IS NOT NULL')
                         ->orderBy('name', 'ASC')
                         ->findColumn('phonecode');
        return $query;
    }
}
