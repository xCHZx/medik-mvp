<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Exception;
use Illuminate\Support\Facades\Log as FacadesLog;

class LogController extends Controller
{
    public function store($type, $content, $category, $userId = 0, $description = ""){

        try{
            FacadesLog::info($content);
            if ($type == "error"){
                FacadesLog::error($description);
            }else{
                FacadesLog::info($description);
            }
            $log = new Log();
            $log->type = $type;
            $log->content = $content;
            $log->category = $category;
            $log->userId = $userId;
            $log->description = $description;

            $log->save();
        }catch(Exception $e){
            FacadesLog::error($e);
            dd($e);
        }

    }
}
