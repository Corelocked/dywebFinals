<div class="comment">
    <div class="body__comment">
        <div class="post">
            <p class="post_name">{{ $comment->post->title }}</p>
            <i class="fa-solid fa-circle"></i>
            <p class="post_user">{{ $comment->post->user->firstname }} {{ $comment->post->user->lastname }}</p>
        </div>
        <div class="head__comment">
            <i class="fa-solid fa-caret-right"></i>
            <p>{{ $comment->name }}</p>
            <p>{{ $comment->created_at->format('d.m.Y H:i') }}</p>
        </div>
        <p>{{ $comment->body }}</p>
    </div>
    <div class="actions">
        <a href="{{ route('post.show', $comment->post->slug) }}" class="redirect_to_post"><p>Go to post</p> <i class="fa-solid fa-angles-right"></i></a>
        @auth
            @if ($comment->user_id === Auth::id())
                <a href="{{ route('comments.edit', $comment->id) }}" class="edit">Edit</a>
            @endif
        @endauth
        @if(Auth::check() && ($comment->user_id === Auth::id() || $comment->post->user_id == Auth::id() || Auth::user()->hasRole('Admin')))
            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" id="comment_{{ $comment->id }}">
                @method('DELETE')
                @csrf
            </form>
            <button onClick="confirmDelete({{ $comment->id }}, 'comment')" class="delete">Delete <i class="fa-solid fa-trash"></i></button>
        @endif
    </div>
</div>
