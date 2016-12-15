<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\APIController;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;

class MeController extends APIController
{
    public function show(Request $request)
    {
        return $this->response($this->transform->item(
            $request->user(),
            new UserTransformer()
        ));
    }
}
