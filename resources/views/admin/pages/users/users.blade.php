@extends('admin.main')

@section('content')
    <style>
        #user a{
            color: #b6d4fe !important;
        }
    </style>
    <!-- Page Content  -->
    <div id="content" class="p-4 p-md-5 pt-5">
        <h2 class="mb-4" >{{$title}}</h2>
        <h6 id="link_url">Users</h6>
        @include('admin.alert')
        <div id="content-body">
            <br>
            <div class="row justify-content-center">
                <div class="col-md-11 content-view" style="background-color: #fff;padding: 8px;border-radius:8px;">
                    <div class="add" style="padding-bottom: 16px">
                        <a href="{{route('add_users')}}" type="button" class="btn btn-success">Add new</a>
                    </div>
                    <div style="overflow-x:auto;">
                        <table class="table table-hover" id ="tblUser">
                            <thead>
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Images</th>
                                <th scope="col">Started date</th>
                                <th scope="col">End date</th>
                                <th scope="col">Status</th>
                                <th scope="col" style="text-align: right">Manipulation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $stt=0; ?>
                            @foreach($user as $u)
                                <?php $stt++ ?>
                                <tr>
                                    <th scope="row">{{$stt}}</th>
                                    <td>{{$u->name}}</td>
                                    <td>{{$u->email}}</td>
                                    <td>
                                        @if(Auth::user()->avatar!="")
                                            <img src="{{$u->avatar}}" width="45" height="45" style="border-radius: 50%">
                                        @else
                                            <img src="/public/images/user/user-img.png" width="45" height="45" style="border-radius: 50%">
                                        @endif
                                    </td>
                                    <td>{{{date("d-m-Y", strtotime($u->start))}}}</td>
                                    <td>{{{date("d-m-Y", strtotime($u->end))}}}</td>
                                    @if($u->status== 2)
                                        <td><span style="background-color: goldenrod; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">New</span></td>
                                    @elseif($u->status == 1)
                                        <td><span style="background-color: green; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Active</span></td>
                                    @elseif($u->status == 0)
                                        <td><span style="background-color: red; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Inactive</span></td>
                                    @endif
                                    <td style="text-align: right">
                                        @if($u->level==2)
                                            <a href="user/edit/{{$u->id}}" style="font-size: 20px;color: blue"title="Edit account"><i class='bx bxs-edit-alt' ></i></a>
                                            <a  onclick="removeRow({{$u->id}},'user/destroy')" style="font-size: 20px;color: red"title="Delete account"><i class='bx bx-window-close'></i></a>
                                            @if($u->lock ==1)
                                                <a href="user/grant/{{$u->id}}" style="color: gold; font-size: 20px;" title="Upgrade permissions"><i class='bx bxs-up-arrow-circle'></i></a>
                                                <a href="user/lock/{{$u->id}}" style="color: darkred;font-size: 20px;" title="Lock account"><i class='bx bxs-lock-alt' ></i></a>
                                            @else
                                                <a href="user/unlock/{{$u->id}}" style="font-size: 20px;"title="Unlock account"><i class='bx bxs-lock-open-alt'></i></a>
                                            @endif
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
        $(document).ready( function () {
            $('#tblUser').DataTable();
        } );
    </script>
@endsection

