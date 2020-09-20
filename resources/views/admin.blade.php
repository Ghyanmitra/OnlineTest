@extends('layouts.app')

@section('content')
<div class="container">

    @if ($users[0])
        <table class="table table-hover" id="datatable">
            <thead>
                <tr>
                <th>@sortablelink('id')</th>
                <th>@sortablelink('name')</th>
                <th>@sortablelink('email')</th>
                <th>@sortablelink('mobileno')</th>
                <th>@sortablelink('marks')</th>
                <th>@sortablelink('created_at')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $row)
                    <tr>
                        <th>{{ $row->id }}</th>
                        <td>{{ $row->name }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->mobileno }}</td>
                        <td>{{ $row->marks?$row->marks:0 }}</td>
                        <td>{{ date("d-m-Y H:i:s A", strtotime($row->created_at)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{$users->links()}}

    @else

        <div><h4>No Record Found</h4></div>

    @endif
</div>
@endsection
