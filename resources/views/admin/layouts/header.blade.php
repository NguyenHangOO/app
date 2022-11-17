<!doctype html>
<html lang="en">
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon"  href="public/images/logo/logo.png">
    <base href="/">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.0.js" ></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" />
</head>
<body>
<div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
        <div class="custom-menu">
            <button type="button" id="sidebarCollapse" class="btn btn-primary">
                <i class="fa fa-bars"></i>
                <span class="sr-only">Toggle Menu</span>
            </button>
        </div>
        <div class="p-4 pt-5">
            <h1 style="text-align: center"><a href="{{route('admin')}}" class="logo"><img src="public/images/logo/logo.png" width="80px"></a></h1>
            <ul class="list-unstyled components mb-5">

                <li id="home">
                    <a href="{{route('admin')}}">Dashboard</a>
                </li>
                @if(Auth::user()->level == 1)
                    <li id="tasks">
                        <a href="{{route('tasks')}}">Tasks</a>
                    </li>
                    <li id = "user">
                        <a href="{{route('users')}}">User</a>
                    </li>
                @endif
                <li id="account">
                    <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Account</a>
                    <ul class="collapse list-unstyled" id="userSubmenu">
                        <li>
                            <a data-toggle="modal" data-target="#fcapnhatthongtin">Profile</a>
                        </li>
                        <li>
                            <a data-toggle="modal" data-target="#fdoimatkhau">Change Password</a>
                        </li>
                        <li>
                            <a href="{{route('logout')}}">Log out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <div class="profile-details">
                <div class="profile-content">
                    @if(Auth::user()->avatar!="")
                        <img src="{{Auth::user()->avatar}}" alt="">
                    @else
                        <img src="/public/images//user/user-img.png" alt="">
                    @endif
                </div>
                <div class="name-job">
                    <div class="profile_name"><span></span></div>
                    <div class="job">{{Auth::user()->name}}</div>
                </div>
            </div>
            <div class="mb-5">
            </div>
        </div>
    </nav>
    <div class="modal fade" id="fcapnhatthongtin" role="dialog" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Profile</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form method="post" action="user/up_profile" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center">
                            @if(Auth::user()->avatar!="")
                                <img class="img-circle" src="{{Auth::user()->avatar}}"  id="image_user" width="100" height="100" style="border-radius: 50%">
                            @else
                                <img class="img-circle" src="public/images/user/user-img.png"  id="image_user" width="100" height="100" style="border-radius: 50%">
                            @endif
                        </div>
                        @if(Auth::user()->level == 1)
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name"
                                       placeholder="Enter name" value="{{Auth::user()->name}}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email"
                                       placeholder="Enter email" value="{{Auth::user()->email}}" required >
                            </div>
                            <div class="form-group">
                                <label>Started date</label>
                                <input class="form-control" type="date" name="start"
                                       placeholder="Started date" value="{{Auth::user()->start}}"required>
                            </div>
                            <div class="form-group">
                                <label>End date</label>
                                <input class="form-control" type="date" name="end"
                                       placeholder="End date" value="{{Auth::user()->end}}"required>
                            </div>
                            <div class="form-group">
                                <label for="status"><span style="color: red;">*</span>Status:</label>
                                <select class="form-control" id="status" name ="status">
                                    @if(Auth::user()->status == 2)
                                        <option value="2">--New--</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    @elseif(Auth::user()->status == 1)
                                        <option value="1">--Active--</option>
                                        <option value="0">Inactive</option>
                                        <option value="2">New</option>
                                    @elseif(Auth::user()->status == 1)
                                        <option value="0">--Inactive--</option>
                                        <option value="2">New</option>
                                        <option value="1">Active</option>
                                    @endif
                                </select>
                            </div>
                        @elseif(Auth::user()->level == 2)
                            <div class="form-group">
                                <label>Name</label>
                                <input class="form-control" type="text" name="name"
                                       placeholder="Enter name" value="{{Auth::user()->name}}"disabled>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email"
                                       placeholder="Enter email" value="{{Auth::user()->email}}" disabled>
                            </div>
                            <div class="form-group">
                                <label>Started date</label>
                                <input class="form-control" type="date" name="start"
                                       placeholder="Started date" value="{{Auth::user()->start}}"disabled>
                            </div>
                            <div class="form-group">
                                <label>End date</label>
                                <input class="form-control" type="date" name="end"
                                       placeholder="End date" value="{{Auth::user()->end}}"disabled>
                            </div>
                            <div class="form-group">
                                <label for="status"><span style="color: red;">*</span>Status:</label>
                                <select class="form-control" id="status" name ="status">
                                    @if(Auth::user()->status == 2)
                                        <option value="2">--New--</option>
                                    @elseif(Auth::user()->status == 1)
                                        <option value="1">--Active--</option>
                                    @elseif(Auth::user()->status == 1)
                                        <option value="0">--Inactive--</option>
                                    @endif
                                </select>
                            </div>
                        @endif
                        <div class="form-group">
                            @if(Auth::user()->level == 1)
                                <span style="background-color: goldenrod; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Admin</span>
                            @elseif(Auth::user()->level == 2)
                                <span style="background-color: green; padding: 4px; font-size: 14px; border-radius: 4px; color: white;font-weight: bold">Employees</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Change avatar</label>
                            <input type="file" id="img_file_user" name="image">
                            <input type="hidden" value="{{Auth::user()->avatar}}" name="link">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--kết thúc cập nhật thông tin người dùng-->

    <!--Bắt đầu đổi mật khẩu-->
    <div class="modal fade" id="fdoimatkhau" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Change Password</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">
                    <form method="post" action="user/up_pass" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Your now password</label>
                            <input class="form-control" type="password" name="password_now"
                                   placeholder="Enter your now password" required>
                        </div>
                        <div class="form-group">
                            <label>Your new password</label>
                            <input class="form-control" type="password" name="password_new"
                                   placeholder="Enter your new password" required>
                        </div>
                        <div class="form-group">
                            <label>Enter the password</label>
                            <input class="form-control" type="password" name="cf_password_new"
                                   placeholder="Enter the new password" required>
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Update">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("img_file_user").onchange = function () {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("image_user").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        };
    </script>
