@extends('layout.main_layout')
@section('content')


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col">
            @include('top_bar')

            <form action="/changePasswordSubmit" method="post" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="text_password" class="form-label">Password</label>
                    <input type="password" class="form-control bg-dark text-info" name="text_password" required>
            
                    {{-- Exibir erro caso exista --}}
                    @error('text_password')
                        <div class="text-danger"> {{$message}}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-secondary w-100">UPDATE</button>
                </div>
            </form>
            
            

        </div>
    </div>
</div>


@endsection