<?php

namespace App\Http\Controllers;

use App\Models\User;

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
    echo 'I create new note!';
   }

   public function editNote($id){
      
   }
}
