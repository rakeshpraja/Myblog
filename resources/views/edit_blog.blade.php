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
            <h2>Edit Post</h2>
            <form action="" id="edit_form" method="post" class="form-container">
                <div>
                    <label for="title">Title:</label>
                    <input type="text" value="{{ $edit_post->title }}" class="form-control" id="title" name="title">
                    <div class="invalid-feedback" id="title_error"></div>
                </div>

                <div>
                    <label for="content">Content:</label>
                    <textarea id="content" class="form-control" name="content" rows="10">{{ $edit_post->content }}</textarea>
                    <div class="invalid-feedback" id="content_error"></div>
                </div>

                <div>
                    <button class="btn btn-success" type="submit">Update</button>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#edit_form').on('submit', function(e) {
                e.preventDefault();

               
                $('#title_error').text('');
                $('#content_error').text('');

               
                var formData = {
                    title: $('#title').val(),
                    content: $('#content').val(),
                    _token: '{{ csrf_token() }}' 
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route("post.update", $edit_post->id) }}',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            alert('Post updated successfully!');
                            window.location.href = '/single_post/' + {{ json_encode($edit_post->id) }}; // Redirect to posts page or wherever
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                           
                            var errors = xhr.responseJSON.errors;
                            if (errors.title) {
                                $('#title_error').text(errors.title[0]);
                                $('#title').addClass('is-invalid');
                            }
                            if (errors.content) {
                                $('#content_error').text(errors.content[0]);
                                $('#content').addClass('is-invalid');
                            }
                        } else {
                            alert('An error occurred while updating the post.');
                        }
                    }
                });
            });
        });
    </script>


</body>

</html>