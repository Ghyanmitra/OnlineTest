@extends('layouts.app')

@section('content')

@if(Auth::user()->role == "Admin")
    <script>window.location = "/admin";</script>
@endif

<div class="container"  onmousedown="return false" onselectstart="return false">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header" id="status"></div>

                <form method="POST" action="{{ route('submitexam') }}" id ="test_form">
                        @csrf

                        @foreach ($exam_data as $key => $items)

                            <div class="card-body form-group" >{{$key+1}} {!!$items["question"]!!}
                                <div></div>
                                <div>

                                {{-- <input  type="hidden" name="{{$key}}" value="NA"> --}}

                                @foreach ($items["options"] as $item)
                                    <input type="radio" name="{{$key}}" value="{{$item}}">
                                    <label for="{{$item}}">{!!$item!!}</label><br>
                                @endforeach
                                </div>
                            </div>

                            @if ($key!=9)
                                <hr>
                            @endif

                        @endforeach

                    <div class="text-center mt-4">
                        <button type="Submit" class="btn btn-primary w-100">Submit</button>
                    </div>
                </form>

        </div>
    </div>
</div>
<script type = "text/javascript">

    document.onkeydown = function(){
    switch (event.keyCode){
            case 116 : //F5 button
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            case 82 : //R button
                if (event.ctrlKey){
                    event.returnValue = false;
                    event.keyCode = 0;
                    return false;
                }
        }
    }

    secs = 600;
    timer = setInterval(function () {
        var element = document.getElementById("status");
        element.innerHTML ="Please select correct Answer <b>"+ secs+" Seconds</b> left";
        if(secs < 1){
            clearInterval(timer);
            document.getElementById('test_form').submit();
        }
        secs--;
    }, 1000)

</script>
@endsection
