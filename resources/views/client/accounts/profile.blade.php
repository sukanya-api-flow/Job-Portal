@extends('client.layouts.app')
@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href= "{{route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
               @include('client.accounts.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <form action="" name="profileForm" id="profileForm">
                        @csrf
                    <div class="card-body  p-4">
                        <h3 class="fs-4 mb-1">My Profile</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" value="{{$user->name}}"placeholder="Enter Name" class="form-control" value="">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" value="{{$user->email}}" placeholder="Enter Email" class="form-control" readonly>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Designation*</label>
                            <input type="text" name="designation" id="designation" value="{{$user->designation}}" placeholder="Designation" class="form-control">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>  
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Mobile*</label>
                            <input type="number"  name="mobile" id="mobile" value="{{$user->mobile}}" placeholder="Mobile" class="form-control">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>  
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <div class="success-message text-success"></div>
                        <div class="error-message text-danger"></div>
                    </div>

                </form>

                </div>

                <div class="card border-0 shadow mb-4">
                    <div class="card-body p-4">
                        <h3 class="fs-4 mb-1">Change Password</h3>
                        <div class="mb-4">
                            <label for="" class="mb-2">Old Password*</label>
                            <input type="password" placeholder="Old Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">New Password*</label>
                            <input type="password" placeholder="New Password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" placeholder="Confirm Password" class="form-control">
                        </div>                        
                    </div>
                    <div class="card-footer  p-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="profilePicForm" method="" enctype="multipart/form-data">
      
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="dp"  name="dp">
            </div>
            <div class="d-flex justify-content-end">
                <div id="validationErrors"></div>

                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>
@endsection





@section('customJs')
<script type="text/javascript">
// Function to handle input value changes
$('.form-control').on('input', function() {
    var value = $(this).val().trim(); // Get the trimmed value of the input
    var feedback = $(this).siblings('.valid-feedback');
    if (value !== '') {
        $(this).removeClass('is-invalid').addClass('is-valid');
        if (!$(this).hasClass('is-invalid')) { // Check if there are no error messages
            feedback.addClass('d-block').text('Looks good!');
        } else {
            feedback.removeClass('d-block').text('');
        }
    } else {
        $(this).removeClass('is-valid').addClass('is-invalid');
        feedback.removeClass('d-block').text('');
    }
});
    $(document).ready(function() {
        $("#profileForm").submit(function(e) {
            e.preventDefault();
            var form = $(this);

            $.ajax({
                url: "{{ route('updateProfile') }}",
                type: 'PUT',
                dataType: "json",
                data: form.serializeArray(),
                success: function(response) {
                    // Clear previous error messages
                    form.find('.error-message').text('');
                    // Show success message in form
                    form.find('.success-message').text(response.meassage);
                    window.setTimeout(function(){
                 window.location.href = "{{ route('profile') }}"; // Adjust the route as per your application
                }, 1000);
                },
                error: function(xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    var field = $('#profileForm').find('[name="'+key+'"]');
                    field.addClass('is-invalid').removeClass('is-valid');
                    field.siblings('.invalid-feedback').text(value);
                    field.siblings('.valid-feedback').removeClass('d-block');
                });
                }
            });
        });
    



    $('#profilePicForm').submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            type: 'POST',
            url: "{{ route('updateProfilePic') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.hasOwnProperty('errors')) {
                    var errorsHtml = '<div class="alert alert-danger">';
                    $.each(response.errors, function(key, value) {
                        errorsHtml += '<p>' + value + '</p>';
                    });
                    errorsHtml += '</div>';

                    $('#validationErrors').html(errorsHtml);
                } else {
                    $('#validationErrors').html('');
                    alert('Profile updated successfully');
                    // Close modal or update UI as needed
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
})


</script>


@endsection