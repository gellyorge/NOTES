<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operation;
use Illuminate\Http\Request;

class MainController extends Controller
{
   public function index(){
    //load user's notes
      $id = session('user.id');
      $notes = User::find($id)->notes()->get()->toArray();

    //show home view
    return view('home',['notes'=>$notes]);
   }

   public function newNote(){
    //show new note view
    return view('new_note');
   }
   public function newNoteSubmit(Request $request)
   {
      return 'create';
   }

   public function editNote($id){
      $id = Operation::decryptId($id);
      echo $id;
   }

    
}
