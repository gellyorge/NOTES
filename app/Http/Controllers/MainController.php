<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
      //validade request
      $request->validate(
        // rules
        [
            'text_title' => 'required|min:3|max:200',
            'text_note' => 'required|min:3|max:3000'
        ],
        // error messages
        [
            'text_title.required' => 'O titulo e obrigatorio',
            'text_note.required' => 'A nota e obrigatorio',

             'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
            'text_title.max' => 'O titulo deve ter no maximo :max caracteres',

            'text_note.min' => 'A nota deve ter no minimo :min caracteres',
            'text_note.max' => 'A nota deve ter no maximo :max caracteres'

           
        ]);
      //get user id
      $id = session('user.id');

      //create new note
      $note = new Note();
      $note->user_id = $id;
      $note->title = $request->text_title;
      $note->text= $request->text_note;
      $note->save();

      //redirect to home
      return redirect()->route('home');
   }

   public function editNote($id){
      $id = Operation::decryptId($id);

      //load note
      $note = Note::find($id);

      //shod edit note view
      return view('edit_note', ['note' => $note]);
   }
   public function editNoteSubmit(Request $request)
   {
      //validade request
      $request->validate(
         // rules
         [
             'text_title' => 'required|min:3|max:200',
             'text_note' => 'required|min:3|max:3000'
         ],
         // error messages
         [
             'text_title.required' => 'O titulo e obrigatorio',
             'text_note.required' => 'A nota e obrigatorio',
 
              'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
             'text_title.max' => 'O titulo deve ter no maximo :max caracteres',
 
             'text_note.min' => 'A nota deve ter no minimo :min caracteres',
             'text_note.max' => 'A nota deve ter no maximo :max caracteres'
 
         ]);

      //check if note id exists
      if($request->note_id == null){
         return redirect()->to('/');
      }

      // decrypt note_id
      $id = Operation::decryptId($request->note_id);
      // load note
      $note = Note::find($id);
      // update note
      $note->title = $request->text_title;
      $note->text = $request->text_note;
      $note->save();
      // redirect to home
      return redirect()->to('/');
   }

    
}
