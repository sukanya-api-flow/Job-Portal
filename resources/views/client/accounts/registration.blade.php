
@extends('client.layouts.app')
@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form action="" name="registrationForm" id="registrationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>                        
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>    
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>    
                        </div> 
                        <div class="mb-3">
                            <label for="" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Please Confirm Password">
                            <div class="valid-feedback"></div>
                            <div class="invalid-feedback"></div>    
                        </div> 


                        <button class="btn btn-primary mt-2">Register</button>
                    </form>                    
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
    <script type="text/javascript">
     $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

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

$("#registrationForm").submit(function (e){
    e.preventDefault();
    $.ajax({
        url: "{{ route('processRegistration') }}",
        type: 'POST',
        dataType: "json",
        data: $(this).serializeArray(),
        success: function(data) {
            console.log(data)
            if (data.status == true) {
                $(".alert-success").text(data.meassage);
                  // Your application has indicated there's an error
                 window.setTimeout(function(){
                 window.location.href = "{{ route('login') }}"; // Adjust the route as per your application

}, 3000);
            }
        },
        error: function(xhr, status, error) {
            if(xhr.status == 422) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    var field = $('#registrationForm').find('[name="'+key+'"]');
                    field.addClass('is-invalid').removeClass('is-valid');
                    field.siblings('.invalid-feedback').text(value);
                    field.siblings('.valid-feedback').removeClass('d-block');
                });
            }
        }
    });
});

     })

    </script>
@endsection



