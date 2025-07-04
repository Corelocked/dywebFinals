<a href="{{ route('post.show', $post->slug) }}" class="read_post">
<div class="post">
    @if($post->is_highlighted)
        <div class="highlighted_icon">Featured <i class="fa-solid fa-star"></i></div>
    @endif
    @php
        $categoryImages = [
            'Technology' => 'images/categories/default-tech.jpg',
            'Travel' => 'images/categories/default-travel.jpg',
            'Culinary' => 'images/categories/default-culinary.jpg',
            'Fashion' => 'images/categories/default-fashion.jpg',
            'Health and Fitness' => 'images/categories/default-health.jpg',
            'Science' => 'images/categories/default-science.jpg',
            'Entertainment' => 'images/categories/default-entertainment.jpg',
            'Lifestyle' => 'images/categories/default-lifestyle.jpg',
            'Business and Finance' => 'images/categories/default-business.jpg',
            'Education' => 'images/categories/default-education.jpg',
            'Sport' => 'images/categories/default-sport.jpg',
            'Music' => 'images/categories/default-music.jpg',
            'Arts and Design' => 'images/categories/default-arts.jpg',
            'DIY' => 'images/categories/default-diy.jpg',
            'Games' => 'images/categories/default-games.jpeg',
        ];
        $categoryName = $post->category->name ?? null;
        $defaultImage = isset($categoryImages[$categoryName]) ? asset($categoryImages[$categoryName]) : asset('images/default.jpg');
        $image = $post->image_path ? asset($post->image_path) : $defaultImage;
    @endphp

    <img src="{{ $image }}" alt="{{ $post->title }}">
    <div class="read"><i class="fa-solid fa-angles-right"></i>Read</div>
    <div class="body">
        <div class="top-info">
            @if ($post->category)
                <div class="category" style="background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">{{ $post->category->name }}</div>
            @endif
            @if ($post->read_time)
                <i class="fa-solid fa-clock"></i>
                <p class="reading-time">{{ $post->read_time }} min</p>
            @endif
        </div>
        <p class="title">{{ $post->title }}</p>
        <div class="user">
            <img src="{{ asset($post->user->image_path) }}" alt="user">
            <p>
                <span class="name">{{ $post->user->firstname . ' ' . $post->user->lastname }}</span><br>
                <span class="date"> {{ \Carbon\Carbon::parse($post->created_at)->format('d F, Y') }}</span>
            </p>
        </div>
        <p class="short_body">{{ $post->excerpt }}</p>
    </div>
</div>
</a>
