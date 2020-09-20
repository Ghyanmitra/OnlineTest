@extends('layouts.app')

@section('content')

@if(Auth::user()->role == "Admin")
    <script>window.location = "/admin";</script>
@endif

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($user[0]->marks)
                        Your test score is  <b>{{$user[0]->marks}}</b>
                    @else
                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                       <div><a class="nav-link" href="{{ route('exampage') }}">Start Your test</a> </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
