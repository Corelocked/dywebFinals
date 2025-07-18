<x-main-layout>
    <div class="dashboard">
        <div class="saved_posts">
            <div class="saved_card new_post">
                <form action="{{ route('posts.create') }}" method="GET">
                    <input type="hidden" value="1" name="new">
                    <button type="submit"><i class="fa-regular fa-square-plus"></i></button>
                </form>
                <p>New</p>
            </div>
            @foreach ($posts as $post)
                <x-saved-post-card :post="$post" />
            @endforeach
        </div>
    </div>
</x-main-layout>
