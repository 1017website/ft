<?php

namespace App\Http\Controllers;

use App\Models\SiteSection;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.home.index', ['content' => SiteSection::websiteContent()]);
    }
}
