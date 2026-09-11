<?php

namespace App\Http\Controllers;

use App\Models\DailyVisitor;
use App\Models\SiteSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        DailyVisitor::record($request);

        return view('pages.home.index', ['content' => SiteSection::websiteContent()]);
    }
}
