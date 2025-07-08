<div class="comment" data-comment-id="{{ $comment->id }}">
    <div class="comment-avatar">
        <div class="avatar-circle" title="{{ $comment->name }}">
            {{ strtoupper(substr($comment->name, 0, 1)) }}
        </div>
    </div>
    <div class="comment-content">
        <div class="comment-header">
            <div class="comment-meta">
                <h4 class="comment-author">{{ $comment->name }}</h4>
                <time class="comment-date" datetime="{{ $comment->created_at->toISOString() }}" title="{{ $comment->created_at->format('l, F j, Y \a\t g:i A') }}">
                    {{ $comment->created_at->diffForHumans() }}
                </time>
            </div>
            @if(Auth::check() && (Auth::user()->can('update', $comment) || Auth::user()->can('delete', $comment)))
                <div class="comment-actions">
                    @can('update', $comment)
                        <a href="{{ route('comments.edit', $comment->id) }}" class="action-btn edit-btn" title="Edit comment">
                            <i class="fa-solid fa-edit"></i>
                            <span>Edit</span>
                        </a>
                    @endcan
                    @can('delete', $comment)
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" id="comment_delete_{{ $comment->id }}" class="delete-form">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="action-btn delete-btn" title="Delete comment" onClick="if(confirm('Are you sure you want to delete this comment?')) document.getElementById('comment_delete_{{ $comment->id }}').submit()">
                                <i class="fa-solid fa-trash"></i>
                                <span>Delete</span>
                            </button>
                        </form>
                    @endcan
                </div>
            @endif
        </div>
        <div class="comment-body">
            {!! nl2br(e($comment->body)) !!}
        </div>
    </div>
</div>
