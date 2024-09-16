<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            @if(session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
            @endif
            <h2 class="text-center">User Login</h2>
            <form id="login_form" method="post" class="mt-4">

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


                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary me-2">Login</button>
                    <button type="button" id="sinup_button" class="btn btn-secondary">Register</button>
                </div>

            </form>
           
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#login_form').on('submit', function(e) {
            e.preventDefault();


            $('.form-control').removeClass('is-invalid');


            var email = $('#email').val().trim();
            var password = $('#password').val().trim();
            var isValid = true;


            if (email === '' || !validateEmail(email)) {
                $('#email').addClass('is-invalid');
                isValid = false;
            }
            if (password === '') {
                $('#password').addClass('is-invalid');
                isValid = false;
            }


            if (isValid) {
                var formData = {
                    email: email,
                    password: password,
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route("login.submit") }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = '/blog_list';
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Login failed. Please check your credentials.');
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
    document.getElementById('sinup_button').addEventListener('click', function() {

        window.location.href = '/register_view';
    });
</script>