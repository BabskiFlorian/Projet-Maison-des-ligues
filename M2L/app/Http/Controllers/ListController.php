<?php
namespace App\Http\Controllers;

use App\Models\Collaborateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller // <<< Assurez-vous que c'est bien ListController ici
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $collaborateurs = Collaborateur::all(); // Assurez-vous que Collaborateur est en majuscule
        $loggedInUser = Auth::user();
        return view('liste', compact('collaborateurs', 'loggedInUser'));
    }
}   