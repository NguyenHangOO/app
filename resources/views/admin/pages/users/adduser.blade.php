@extends('admin.main')

@section('content')
    <style>
        #user a{
            color: #b6d4fe !important;
        }
    </style>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >Add user</h2>
        <h6 id="link_url"><a href="{{route('users')}}">User</a> / Add new</h6>
        @include('admin.alert')
        <br>
        <div class="row justify-content-center" >
            <div class="col-md-8" id="style" >
                <div class="add-category">
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="name"><span style="color: red;">*</span>Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><span style="color: red;">*</span>Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="form-group ">
                        <label for="start"><span style="color:red;">*</span>Enter started date:</label>
                        <input type="date" class="form-control" id="start" placeholder="Enter started date" name="start" required>
                    </div>
                    <div class="form-group">
                        <label for="end"><span style="color: red;">*</span>End date:</label>
                        <input type="date" class="form-control" id="end" name="end" required>
                    </div>
                    <div class="form-group">
                        <label for="status"><span style="color: red;">*</span>Status:</label>
                        <select class="form-control" id="status" name ="status">
                            <option value="2">New</option>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Add new</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>

@endsection
