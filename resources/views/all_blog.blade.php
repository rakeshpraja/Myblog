<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Blog Posts - My Blog</title>
    <link rel="stylesheet" href="styles.css">
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
            <h2>All Blog Posts</h2>

            <!-- List of blog posts -->
            <div class="post-list">
                <!-- Repeat this block for each blog post -->
                @if(count($all_post)>0)
                @foreach($all_post as $value)
                <article class="post">
                    <h3><a href="{{url('single_post/'.$value->id)}}">{{$value->title}}</a></h3>
                    <p>{{$value->content}}</p>

                    <a href="{{url('single_post/'.$value->id)}}">view post</a>
                </article>
                @endforeach
                @else
                <article class="post">
                    <h5 class="text-danger">Post is not fount</h5>

                </article>
                @endif
                <!-- Add more blog post blocks here -->
            </div>
        </main>
    </div>

    <footer>
        <div class="container">
            &copy; 2024 My Blog. All rights reserved.
        </div>
    </footer>
</body>

</html>