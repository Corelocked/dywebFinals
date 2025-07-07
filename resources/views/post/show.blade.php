<x-main-layout>
    <div class="article post-show">
        <div class="post_container">
            <div class="top">
                <img src="{{ $post->image_path ? asset($post->image_path) : asset('images/picture3.jpg') }}" alt="{{ $post->title }}">
                <div class="info">
                    <h1 class="title">{{ $post->title }}</h1>
                    
                    <div class="meta-info">
                        @if ($post->category)
                            <div class="category" style="background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">
                                {{ $post->category->name }}
                            </div>
                        @endif
                        
                        @if ($post->read_time)
                            <div class="reading-info">
                                <p class="reading-text">Reading time: </p>
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ $post->read_time }} min</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="date-info">
                        <p class="date">
                            <i class="fa-regular fa-calendar"></i>
                            {{ $post->created_at->format('d.m.Y') }} by {{ $post->user->firstname . ' ' . $post->user->lastname }}
                        </p>
                        @if($post->created_at != $post->updated_at)
                            <p class="date">
                                <i class="fa-regular fa-calendar-check"></i>
                                Updated: {{ $post->updated_at->format('d.m.Y') }}
                            </p>
                        @endif
                        @if($post->is_published == false)
                            <p class="date unpublished">
                                <i class="fa-solid fa-eye-slash"></i>
                                (Not visible to public)
                            </p>
                        @endif
                    </div>
                    
                    @can(['post-super-list', 'post-edit'])
                        <a href="{{ route('posts.edit', $post->id) }}" class="edit">
                            <i class="fa-solid fa-edit"></i> Edit Post
                        </a>
                    @else
                        @if(Auth::User())
                            @if(Auth::User()->id == $post->user_id AND Auth::User()->can('post-edit'))
                                <a href="{{ route('posts.edit', $post->id) }}" class="edit">
                                    <i class="fa-solid fa-edit"></i> Edit Post
                                </a>
                            @endif
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        <div class="post_body">

            {!! $post->body !!}

            <div class="actions">
                @isset($nextPost)
                    <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Back to home page</a>
                    <a href="{{ route('post.show', $nextPost->slug) }}">Next post <i class="fa-solid fa-arrow-right"></i></a>
                @else
                    <a href="{{ route('home') }}" style="width: 100%"><i class="fa-solid fa-arrow-left"></i> Back to home page</a>
                @endisset
            </div>
        </div>
        <div class="comments">
            <p class="info">Comments ({{ count($post->comments) }})</p>
            <div class="add__comment">
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    @auth
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ Auth::user()->firstname . ' ' . Auth::user()->lastname }}" readonly>
                    @else
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" value="Anonymous User" readonly>
                    @endauth
                    <label for="comment-body">Your Comment</label>
                    <textarea id="comment-body" name="body" placeholder="Share your thoughts about this post..." required></textarea>
                    <input type="submit" value="Post Comment">
                </form>
            </div>
            <div class="line-1"></div>
            @isset($post->comments)
                @if(count($post->comments) > 0)
                    <div class="comments-list">
                        @foreach ($post->comments as $comment)
                            <x-comment-card :comment="$comment" :post="$post" />
                        @endforeach
                    </div>
                @else
                    <div class="no-comments">
                        <p>No comments yet. Be the first to share your thoughts!</p>
                    </div>
                @endif
            @endisset
        </div>
    </div>

    <script>
        document.querySelectorAll('img:not(.profile_img)').forEach(function (img) {
            img.classList.add('img-enlargable');
            img.addEventListener('click', function () {
                let src = img.getAttribute('src');

                let overlay = document.createElement('div');
                overlay.style.cssText = 'background: RGBA(0,0,0,.5) url(' + src + ') no-repeat center; background-size: contain; width: 100%; height: 100%; position: fixed; z-index: 10000; top: 0; left: 0; cursor: zoom-out;';

                overlay.addEventListener('click', function () {
                    overlay.remove();
                });

                document.body.appendChild(overlay);
            });
        });
    </script>
</x-main-layout>
