<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Auth;

class LeagueController
{

    public function join()
    {
        $user = Auth::user();
        $user->joined_league = 1;
        return response()->json([
            'joined' => $user->save()
        ]);
    }
}
