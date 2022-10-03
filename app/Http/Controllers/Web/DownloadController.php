<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DownloadController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagina = \App\Models\Pagina::where('situacao', '1')
            ->where('link', 'downloads')->firstOrFail();

        $downloads = \App\Models\Download::where('situacao', '=', '1')->orderBy('nome', 'asc');

        return view('web.downloads.lista', compact('pagina', 'downloads'));
    }
}
