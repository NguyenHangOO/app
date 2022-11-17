@extends('admin.main')

@section('content')
    <style>
        #tasks a{
            color: #b6d4fe !important;
        }
    </style>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >Add task</h2>
        <h6 id="link_url"><a href="{{route('tasks')}}">Task</a> / Edit task</h6>
        @include('admin.alert')
        <br>
        <div class="row justify-content-center" >
            <div class="col-md-8" id="style" >
                <div class="add-category">
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="mnvu"><span style="color: red;">*</span>Task code:</label>
                        <input type="text" class="form-control" id="mnvu" placeholder="Enter task code" name="mnvu" value="{{$t->mnvu}}" required>
                    </div>
                    <div class="form-group">
                        <label for="name_nv"><span style="color: red;">*</span>Name:</label>
                        <input type="text" class="form-control" id="name_nv" placeholder="Enter name" name="name_nv" value="{{$t->name_nv}}" required>
                    </div>
                    <div class="form-group ">
                        <label for="start_nv"><span style="color:red;">*</span>Started date:</label>
                        <input type="date" class="form-control" id="start_nv" placeholder="Enter started date" name="start_nv" value="{{$t->start_nv}}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_nv"><span style="color: red;">*</span>End date:</label>
                        <input type="date" class="form-control" id="end_nv" name="end_nv" value="{{$t->end_nv}}" required>
                    </div>
                    <div class="form-group">
                        <label for="performer"><span style="color: red;">*</span>Performer:</label>
                        <select class="form-control" id="performer" name ="performer">
                            @foreach($emp as $e)
                                @if($t->user_id == $e->id)
                                    <option value="{{$e->id}}">{{$e->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    @csrf
                </form>
            </div>
        </div>
    </div>

@endsection
