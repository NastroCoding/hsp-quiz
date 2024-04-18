@extends('layouts.admin')
@section('container')

<link rel="stylesheet" href="{{URL::asset('dist/css/style.css')}}">
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/admin/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div id="settings">
                                <form class="form-horizontal">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <div class="profile-img-container">
                                                <label for="profile-picture-input">
                                                    <img id="profile-picture" class="profile-user-img img-fluid img-circle" src="{{URL::asset('/dist/img/user.png')}}" alt="User profile picture">
                                                    <div class="overlay"></div>
                                                    <span class="edit-icon"><i class="fas fa-pencil-alt"></i></span>
                                                </label>
                                                <input type="file" id="profile-picture-input" accept="image/*" style="display: none;">
                                            </div>
                                        </div>
                                        <h3 class="profile-username text-center">Admin</h3>
                                        <p class="text-muted text-center">Superadmin</p> <!-- role disini -->
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputName" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" class="btn btn-success">Save changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

<script>
    // Get the input file element
    var inputFile = document.getElementById('profile-picture-input');
    // Add event listener for file input change
    inputFile.addEventListener('change', function(event) {
        // Get the selected file
        var selectedFile = event.target.files[0];
        // Check if a file is selected
        if (selectedFile) {
            // Create a FileReader object
            var reader = new FileReader();
            // Set up FileReader onload function
            reader.onload = function() {
                // Update the src attribute of the profile picture with the selected image
                document.getElementById('profile-picture').src = reader.result;
            };
            // Read the selected file as a Data URL
            reader.readAsDataURL(selectedFile);
        }
    });
</script>
@endsection