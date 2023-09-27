<h1>{{ $title }}</h1>
<h2>{{ $subtitle }}</h2>

<div class="blog-posts">

    @foreach ($posts as $post)
        <h3>{{ $post->title }}</h3>
        <p>{{ $post->content }}</p>
    @endforeach

</div>