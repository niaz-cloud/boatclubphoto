<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    //
    public function home(Request $request) {
        $data = array();

        $data['total_student'] = 0;
        $data['active_menu'] = 'dashboard';
        $data['page_title'] = 'Dashboard';

        return view('frontend.pages.home', compact('data'));
    }
}
