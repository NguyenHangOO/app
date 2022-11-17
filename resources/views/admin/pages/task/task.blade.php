@extends('admin.main')

@section('content')
    <style>
        #tasks a{
            color: #b6d4fe !important;
        }
    </style>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >{{$title}}</h2>
        <h6 id="link_url">Task</h6>
        @include('admin.alert')
        <div id="content-body">
            <br>
            <div class="row justify-content-center">
                <div class="col-md-11 content-view" style="background-color: #fff;padding: 8px;border-radius:8px;">
                    <div class="add" style="padding-bottom: 16px">
                        <a href="{{route('add_tasks')}}" type="button" class="btn btn-success">Add new</a>
                    </div>
                    <div class="col-md-11">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 pl-1 mt-3">
                                <div class="form-group" id="filter_col4" data-column="4">
                                    <label class="form-label" >Status</label>

                                    <select name="status" class="form-control column_filter " id="col4_filter">
                                        <option value="0">Unfinished</option>
                                        <option value="1">Accomplished</option>
                                        <option value="">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 pl-1 mt-3">
                                <div class="form-group" id="filter_col7" data-column="7">
                                    <label class="form-label">Performer</label>
                                    <select name="performer" class="form-control column_filter " id="col7_filter">
                                        <option value="">--All--</option>
                                        @foreach($user as $u)
                                            @if($u->level == 2)
                                                <option value="{{$u->name}}">{{$u->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div style="overflow-x:auto;">
                        <table class="table table-hover" id ="tblTask">
                            <thead>
                            <tr>
                                <th scope="col">Task code</th>
                                <th scope="col">Name</th>
                                <th scope="col">Start</th>
                                <th scope="col">End</th>
                                <th scope="col" style="display: none"></th>
                                <th scope="col">Finish</th>
                                <th scope="col">Creator</th>
                                <th scope="col">Performer</th>
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
                                    <td>
                                        @foreach($user as $u)
                                            @if($t->user_id == $u->id)
                                                {{$u->name}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="text-align: right">
                                        @if($t->status_nv == 0)
                                            <a href="task/edit/{{$t->id}}" style="font-size: 20px;color: blue"title="Edit task"><i class='bx bxs-edit-alt' ></i></a>
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
    </div>
    <script>
        function filterGlobal () {
            $('#tblTask').DataTable().search(
                $('#global_filter').val(),

            ).draw();
        }
        function filterColumn ( i ) {
            $('#tblTask').DataTable().column( i ).search(
                $('#col'+i+'_filter').val()
            ).draw();
        }
        //start
        $(document).ready(function() {
            $('#tblTask').DataTable();
            $('#tblTask').DataTable().column(4).search('0').draw();
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

