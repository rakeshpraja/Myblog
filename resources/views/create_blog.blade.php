<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post - My Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{asset('styles.css')}}">
</head>

<body>
    <header>
        <div class="container">
            <h1>My Blog</h1>
            <nav>
                <a href="{{url('blog_list')}}">Home</a>
                
                <a href="{{url('index')}}">Creat Post</a>
                <a href="{{url('logout')}}">Logout</a>
               
            </nav>
        </div>
    </header>

    <div class="container">
        <main class="main-content">
            <h2>Create New Post</h2>
            <form action="" id="submit_form" method="post" class="form-container">

                <div>
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>


                <div>
                    <label for="content">Content:</label>
                    <textarea id="content" class="form-control" name="content" rows="10"></textarea>
                </div>


                <div>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>

        </main>
    </div>

    <footer>
        <div class="container">
            &copy; 2024 My Blog. All rights reserved.
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#submit_form').on('submit', function(e) {
                e.preventDefault();


                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').remove();


                var formData = {
                    title: $('#title').val(),
                    content: $('#content').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route("posts.store") }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);

                            window.location.href = '/index';

                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            for (var field in errors) {
                                $('#' + field).addClass('is-invalid');

                                var errorDiv = '<div class="invalid-feedback text-danger">' + errors[field][0] + '</div>';
                                $('#' + field).after(errorDiv);
                            }
                        } else {

                            alert('An error occurred. Please try again.');
                        }
                    }
                });
            });
        });
    </script>


</body>

</html>