<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Post Title - My Blog</title>
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
        @if(!empty($single_post))

        <main class="main-content">
            <article class="post">
                <h2>{{$single_post->title??""}}</h2>
                <p>{{$single_post->content??""}}</p>
                <h5>Auhor By:{{$single_post->user->name??""}}</h5>
            </article>
            <a href="{{url('edit_post/'.$single_post->id)}}">edit post</a> &nbsp;&nbsp;&nbsp;&nbsp;
            <a href="javascript:void(0)" class="btn btn-danger" id="delete_post" data-id="{{ $single_post->id }}">delet post</a>


        </main>
        @endif
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
            $('#delete_post').on('click', function(e) {
                e.preventDefault();


                if (!confirm('Are you sure you want to delete this post?')) {
                    return;
                }

                var postId = $(this).data('id');

                $.ajax({
                    url: '/delete_post/' + postId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = '/blog_list';
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to delete post. Please try again.');
                    }
                });
            });
        });
    </script>


</body>

</html>