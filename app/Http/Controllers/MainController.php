<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MainController extends Controller
{
   public function index(){
    //load user's notes
      $id = session('user.id');
      $notes = User::find($id)->notes()
         ->whereNull('deleted_at')
         ->get()
         ->toArray();

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
            'text_note' => 'max:3000'
        ],
        // error messages
        [
            'text_title.required' => 'O titulo e obrigatorio',

             'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
            'text_title.max' => 'O titulo deve ter no maximo :max caracteres',
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
             'text_note' => 'max:3000'
         ],
         // error messages
         [
             'text_title.required' => 'O titulo e obrigatorio',
 
              'text_title.min' => 'O titulo deve ter no minimo :min caracteres',
             'text_title.max' => 'O titulo deve ter no maximo :max caracteres',
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

   public function deleteNote($id){
      $id = Operation::decryptId($id);

      //load note
      $note = Note::find($id);

      //show delete note confirmation
      return view('delete_note', ['note' => $note]);

   }
   public function deleteConfirm($id){
      //check if id is encrypted
      $id = Operation::decryptId($id);
      //load note
      $note = Note::find($id);

      //1. hard delete
      //$note->delete();

      //2. soft delete
      //$note-> deleted_at = date('Y-m-d H:i:s');
      //$note-> save();

      //3. soft delete in model
      $note->delete();

      //redirect to home
      return redirect()->route('home');
   }

   public function changePassword(){
      return view('changePassword');
   }

   public function changePasswordSubmit(Request $request){
      $id = session('user.id');
      $request->validate(
         // rules
         [
             'text_password' => 'required|min:6|max:16'
         ],
         // error messages
         [
             'text_password.required' => 'A password e obrigatorio',
             'text_password.min' => 'A password deve ter no minimo :min caracteres',
             'text_password.max' => 'A password deve ter no maximo :max caracteres'
         ]
     );
      $user = User::find($id);
      $user->password = Hash::make($request->text_password);
      $user->save();
      return redirect()->to('/');
   }

    
}
