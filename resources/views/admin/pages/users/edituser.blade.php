@extends('admin.main')

@section('content')
    <style>
        #product a{
            color: #b6d4fe !important;
        }
    </style>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >{{$title}}</h2>
        <h6 id="link_url"><a href="{{route('users')}}">Users</a> / Edit user</h6>
        @include('admin.alert')
        <br>
        <div class="row justify-content-center" >
            <div class="col-md-10" id="style" >
                <div class="add-category">
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name"><span style="color: red;">*</span>Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="{{$u->name}}" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="color: red;">*</span>Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{$u->email}}" required>
                    </div>
                    <div class="form-group ">
                        <label for="start"><span style="color:red;">*</span>Enter started date:</label>
                        <input type="date" class="form-control" id="start" value="{{$u->start}}" name="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end"><span style="color: red;">*</span>End date:</label>
                        <input type="date" class="form-control" id="end" name="end" value="{{$u->end}}" required>
                    </div>
                    <div class="form-group">
                        <label for="status"><span style="color: red;">*</span>Status:</label>
                        <select class="form-control" id="status" name ="status">
                            @if($u->status == 2)
                                <option value="2">--New--</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            @elseif($u->status == 1)
                                <option value="1">--Active--</option>
                                <option value="0">Inactive</option>
                                <option value="2">New</option>
                            @elseif($u->status == 1)
                                <option value="0">--Inactive--</option>
                                <option value="2">New</option>
                                <option value="1">Active</option>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Edit</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>
    @endsection
