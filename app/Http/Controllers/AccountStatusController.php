<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountStatus;

class AccountStatusController extends Controller
{
    public function getStatusId($statusName)
    {
        $statusId = AccountStatus::where('name' , $statusName)->value('id');
        return $statusId;
    }
}
