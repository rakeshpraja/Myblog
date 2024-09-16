<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">User Register</h2>
            <form id="register_form" method="post" class="mt-4">

                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">Please enter a name.</div>
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">Please enter a valid email.</div>
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="invalid-feedback">Password is required.</div>
                </div>


                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password:</label>
                    <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                    <div class="invalid-feedback">Passwords must match.</div>
                </div>


                <div class="d-flex justify-content-center">
                    
                    <button type="submit"  class="btn btn-secondary me-2">Register</button>
                    <button type="button" id="login-button" class="btn btn-primary ">Login</button>
                </div>
            </form>
            
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#register_form').on('submit', function(e) {
            e.preventDefault();


            $('.form-control').removeClass('is-invalid');


            var name = $('#name').val().trim();
            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var passwordConfirm = $('#password-confirm').val().trim();
            var isValid = true;


            if (name === '') {
                $('#name').addClass('is-invalid');
                isValid = false;
            }
            if (email === '' || !validateEmail(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            }
            if (password === '' || password !== passwordConfirm) {
                $('#password').addClass('is-invalid');
                $('#password-confirm').addClass('is-invalid');
                isValid = false;
            }


            if (isValid) {
                var formData = {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm,
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route("register.submit") }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '/register_view';
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Registration failed. Please try again.');
                    }
                });
            }
        });


        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
    });
</script>
<script>
    document.getElementById('login-button').addEventListener('click', function() {

        window.location.href = '/';
    });
</script>