
@extends('layouts.admin')

@section('content')

<div id="messages_index">

    <div class="container mt-3 mb-5 table-responsive">

        <div class="d-flex my-5 justify-content-center justify-content-lg-start">
            <a class="btn btn-outline-primary me-3" href="{{route('admin.dashboard')}}">Dashboard</a>
            <a class="btn btn-outline-primary me-3"  href="{{route ('admin.apartments.index')}}">I Tuoi Appartamenti</a>
          </div>

        @if(count($messages)>0)
            @foreach ($messages as $message)  
            <div class="card my-3">
                <div class="card-header">{{$message->apartment->name}}</div>
                <div class="card-body">
                    <p><strong>Data:</strong> {{$message->created_at}}</p>
                    <p><strong>Nome:</strong> {{$message->username}}</p>
                    <p><strong>Contenuto:</strong> {{$message->content}}</p>
                    <p><strong>Email:</strong> {{$message->email}}</p>
                </div>

            </div>
            @endforeach
        @else
        <div class=" my-3 _alert">
            <div class="alert alert-light" role="alert">
                Non hai ricevuto messaggi per questo appartamento
            </div>
        </div>
        @endif
        
    </div>
    

</div>

@endsection
