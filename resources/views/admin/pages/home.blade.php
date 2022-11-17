@extends('admin.main')
@section('content')
    <style>
        #home a{
            color: #b6d4fe !important;
        }
    </style>

    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >{{$title}}</h2>
        @include('admin.alert')
        @if(Auth::user()->level == 1)
            <div class="row justify-content-center">
                <div class="col-sm-4">
                    <div class="card mb-3" style="max-width: 22rem;">
                        <div class="card-body text-white bg-info">
                            <h1 class="card-text text-right" style="color: #FFFFFF">{{$sum_user}}</h1>
                            <h5 class="card-title text-right">Employees </h5>
                        </div>
                        <div class="card-footer text-right bg-transparent border-info">
                            <a href="{{route('users')}}">See details<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card mb-3" style="max-width: 22rem;">
                        <div class="card-body text-white bg-danger">
                            <h1 class="card-text text-right" style="color: #FFFFFF">{{$sum_task}}</h1>
                            <h5 class="card-title text-right">Unfinished task</h5>
                        </div>
                        <div class="card-footer text-right bg-transparent border-danger">
                            <a href="{{route('tasks')}}">See details<i class="bi bi-chevron-double-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12 content-view" style="background-color: #fff;padding: 16px;border-radius:8px">
                <h5>Task for you</h5>
                <div class="row justify-content-center">
                    <div class="col-md-3 col-sm-3 pl-1 mt-3">
                        <div class="form-group" id="filter_col4" data-column="4">
                            <label class="form-label" >Status:</label>
                            <select name="status" class="form-control column_filter " id="col4_filter">
                                <option value="0">Unfinished</option>
                                <option value="1">Accomplished</option>
                                <option value="">All</option>
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div style="overflow-x:auto;">
                    <table class="table table-hover" id ="tblTask_user">
                        <thead>
                        <tr>
                            <th scope="col">Task code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Start</th>
                            <th scope="col">End</th>
                            <th scope="col" style="display: none"></th>
                            <th scope="col">Finish</th>
                            <th scope="col">Creator</th>
                            <th scope="col" style="text-align: right">Manipulation</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($task as $t)
                            <tr>
                                <td>{{$t->mnvu}}</td>
                                <td>{{$t->name_nv}}</td>
                                <td>{{date("d-m-Y", strtotime($t->start_nv))}}</td>
                                <td>{{date("d-m-Y", strtotime($t->end_nv))}}</td>
                                <td style="display: none">{{$t->status_nv}}</td>
                                @if($t->status_nv== 1)
                                    <td><span style="background-color: lightgreen; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">{{{date("d-m-Y", strtotime($t->finish_nv))}}}</span></td>
                                @elseif($t->status_nv == 0)
                                    <td><span style="background-color: indianred; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Unfinished</span></td>
                                @endif
                                <td>
                                    @foreach($user as $u)
                                        @if($t->creat_id == $u->id)
                                            {{$u->name}}
                                        @endif
                                    @endforeach
                                </td>
                                <td style="text-align: right">
                                    @if($t->status_nv == 0)
                                        <a data-toggle="modal" data-target="#check" onclick="getCheck({{$t->id}})" type="button"  title ="Sửa" >
                                            <span style="background-color: darkblue; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Complete</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="check" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Confirm</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('check')}}">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                           <span style="text-align: center">
                               <h5>Confirm quest completion.</h5>
                               <h5>After confirming not to change.</h5>
                           </span>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id_check" id="id_check" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input class="btn btn-primary" type="submit" value="Complete">
                    </div>
                </form>
                <script>
                    function getCheck(e){
                        $('#id_check').val(e);
                    }
                </script>
            </div>
        </div>
    </div>
    <script>
        function filterGlobal () {
            $('#tblTask_user').DataTable().search(
                $('#global_filter').val(),

            ).draw();
        }
        function filterColumn ( i ) {
            $('#tblTask_user').DataTable().column( i ).search(
                $('#col'+i+'_filter').val()
            ).draw();
        }
        //start
        $(document).ready(function() {
            $('#tblTask_user').DataTable();
            $('#tblTask_user').DataTable().column(4).search('0').draw();
            $('input.global_filter').on( 'keyup click', function () {
                filterGlobal();
            } );
            $('input.column_filter').on( 'keyup click', function () {
                filterColumn( $(this).parents('div').attr('data-column') );
            } );
        } );
        //end
        $('select.column_filter').on('change', function () {
            filterColumn( $(this).parents('div').attr('data-column') );
        } );
    </script>
@endsection
