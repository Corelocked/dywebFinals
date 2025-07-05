<x-admin-layout>
    @section('scripts')
        <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
        <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        @vite(['resources/js/post.js', 'resources/js/createPost.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="post__create">
        <form action="{{ route('posts.store') }}" method="POST" id="form" enctype="multipart/form-data">
            @csrf
            <div id="content" data-image-url="{{route('images.store')}}">
            <div class="post_container">
                @if(count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <div class="top">
                    <div class="image">
                        <img src="{{ isset($post) ? ($post->image_path ? asset($post->image_path) : asset('images/picture3.jpg')) : asset('images/picture3.jpg') }}" id="output" alt="image">
                        <input id="image" type="file" name="image" style="display:none;">
                        <div class="change_image" onclick="document.getElementById('image').click();"><i class="fa-solid fa-image"></i> Change</div>
                    </div>
                    <div class="info">
                        <p class="info_title_length">Maximum 255 characters. <span class='current_title_length'>{{ isset($post) ? Str::length($post->title) : 5 }}/255</span></p>
                        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}" class="title" autocomplete="off" placeholder="Title">
                        <div class="reading-info">
                            <p class="reading-text">Reading time: </p>
                            <i class="fa-solid fa-clock"></i>
                            <p class="reading-time">{{ isset($post) ? ($post->read_time ??  0) : 0 }} min</p>
                            <button type="button" class="calculate" onclick="calculateReadTime();">Calculate</button>
                        </div>
                        <p class="date">{{ date('d.m.Y') }} by {{ Auth::User()->firstname . ' ' . Auth::User()->lastname }}</p>
                    </div>
                </div>
            </div>
            <div class="post_body">
                <textarea name="body" id="hiddenArea" style="display:none;">{{ old('body', $post->body ?? '') }}</textarea>
                <div id="editor"></div>

                <div class="actions">
                    <a href="javascript:history.back()"><i class="fa-solid fa-arrow-left"></i> Back</a>
                    <a>Next post <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
            <div class="post_options">
                <div class="header">Additional options:</div>
                <label>Short description</label>
                <p class="info excerpt_length">Maximum 510 characters. <span class='current_excerpt_length'>{{ isset($post) ? Str::length($post->excerpt) : 0 }}/510</span></p>
                <textarea name="excerpt">{{ isset($post) ? $post->excerpt  : '' }}</textarea>
                <label>Visibility</label>
                <div class="published">
                    <p>Set visibility to public</p>
                    <label class="switch">
                        <input type="checkbox" name="is_published" {{ isset($post) ? ($post->is_published ? 'checked' : '') : 'checked' }}>
                        <span class="slider round"></span>
                    </label>
                </div>
                <label>Category</label>
                @isset($post)
                    @isset($post->category)
                        <div class="category-selected" style="border: none; background: {{ $post->category->backgroundColor }}CC; color: {{ $post->category->textColor }}">{{ $post->category->name }}</div>
                    @else
                        <div class="category-selected">Not selected</div>
                    @endisset
                @else
                    <div class="category-selected">Not selected</div>
                @endisset
                <p class="categories_extend" onclick="categoriesToggle();">Hide <i class="fa-solid fa-chevron-up"></i></p>
                <div class="categories_list">
                    @foreach($categories as $category)
                        <div class="category" style="background: {{ $category->backgroundColor }}CC; color: {{ $category->textColor }}" onclick="changeToCategory(event, {{ $category->id }})" data-id="{{ $category->id }}">{{ $category->name }}</div>
                    @endforeach
                </div>
                <input type="hidden" name="category_id" id="category_id" value="{{ isset($post) ? ($post->category ? $post->category->id : '') : '' }}"/>
                <input type="hidden" name="id_saved_post" value="{{ isset($post) ? ($post->id ? $post->id : 0) : 0 }}">
                <div class="create_post_actions">
                    <input type="button" onClick="submitForm();" value="Publish">
                    <div class="save" onClick="savePost();">Save</div>
                </div>
            </div>
        </form>
        <x-select-image />
    </div>

    <script>
        var quill = new Quill('#editor', {
            theme: 'snow'
        });

        quill.on('text-change', function() {
            document.getElementById('hiddenArea').value = quill.root.innerHTML;
        });

        @if(isset($post) && $post->body)
            quill.root.innerHTML = `{!! addslashes($post->body) !!}`;
        @endif

        function submitForm() {
            document.getElementById('hiddenArea').value = quill.root.innerHTML;
            document.getElementById('form').submit();
        }

        // --- CATEGORY DEFAULT IMAGE LOGIC ---
        // Map category IDs to default images
        const categoryImages = {
            @foreach($categories as $category)
                @php
                    $map = [
                        'Health and Fitness' => 'images/categories/default-health.jpg',
                        'Business and Finance' => 'images/categories/default-business.jpg',
                        'Technology' => 'images/categories/default-tech.jpg',
                    ];
                    if (isset($map[$category->name])) {
                        $img = asset($map[$category->name]);
                    } else {
                        $slug = Str::slug($category->name);
                        $ext = ($category->name === 'Games') ? 'jpeg' : 'jpg';
                        $img = asset("images/categories/default-{$slug}.{$ext}");
                    }
                @endphp
                {{ $category->id }}: "{{ $img }}",
            @endforeach
        };

        // Listen for category change
        document.querySelectorAll('.categories_list .category').forEach(function(el) {
            el.addEventListener('click', function() {
                const catId = this.getAttribute('data-id');
                document.getElementById('category_id').value = catId;
                // Only update if no image is selected
                if (!document.getElementById('image').value) {
                    document.getElementById('output').src = categoryImages[catId] || "{{ asset('images/picture3.jpg') }}";
                }
            });
        });
    </script>
</x-admin-layout>