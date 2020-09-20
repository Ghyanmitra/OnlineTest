<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function home()
    {
        $users=User::sortable()->where('role','Guest')->paginate(5);
        return view('admin',["users" =>$users]);
    }
}
