<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function list(Request $request)
    {
        $limit = $request->input('limit');

        return Transaction::with(['details'])->paginate($limit);
    }
}
