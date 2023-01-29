<?php

namespace App\Models;

use CodeIgniter\Model;

class AccountsModel extends Model
{
    protected $table = "accounts";

    protected $primaryKey = 'ID';

    protected $useSoftDeletes = true;

    protected $allowedFields = ['account_name', 'account_pwd', 'account_email'];

    public function getAccounts($id = false)
    {
        if ($id === false) {
            return $this->findAll();
        }

        return $this->where(['ID' => $id])->first();
    }

}

?>