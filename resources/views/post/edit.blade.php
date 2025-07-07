<x-admin-layout :edit="true">
    @section('scripts')
        <script src="//cdn.quilljs.com/1.3.7/quill.js"></script>
        <link href="//cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        @vite(['resources/js/fileUploadLoader.js', 'resources/js/post.js', 'resources/js/editPost.js'])
    @endsection

    <x-dashboard-navbar route="{{ route('posts.index') }}"/>

    <div class="post__create post__edit">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="form">
            @csrf
            @method('PATCH')
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
                        <div class="image image-upload-container">
                            <img src="{{ $post->image_path ? asset($post->image_path) : asset('images/picture3.jpg') }}" id="output" alt="image">
                            <input id="image" type="file" name="image" style="display:none;">
                            <div class="change_image" onclick="document.getElementById('image').click();"><i class="fa-solid fa-image"></i> Change</div>
                        </div>
                        <div class="info">
                            <p class="info_title_length">Maximum 255 characters. <span class='current_title_length'>{{ Str::length($post->title) }}/255</span></p>
                            <input type="text" name="title" class="title" autocomplete="off" value="{{ $post->title }}">
                            <div class="reading-info">
                                <p class="reading-text">Reading time: </p>
                                <i class="fa-solid fa-clock"></i>
                                <p class="reading-time">{{ $post->read_time ? $post->read_time : 0 }} min</p>
                                <button type="button" class="calculate" onclick="calculateReadTime();">Calculate</button>
                            </div>
                            <p class="date">{{ $post->updated_at->format('d.m.Y') }} by {{ $post->user->firstname . ' ' . $post->user->lastname }}</p>
                        </div>
                    </div>
                </div>
                <div class="post_body">
                    <div id="editor">

                    </div>

                    <textarea name="body" style="display: none" id="hiddenArea">{!!$post->body !!}</textarea>

                    <div class="actions">
                        <a href="javascript:history.back()"><i class="fa-solid fa-arrow-left"></i> Back</a>
                        <a>Next post <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="post_options">
                <div class="header">Additional options:</div>
                <label>Short description</label>
                <p class="info excerpt_length">Maximum 510 characters. <span class='current_excerpt_length'>{{ Str::length($post->excerpt) }}/510</span></p>
                <textarea name="excerpt">{{ $post->excerpt }}</textarea>
                <label>Visibility</label>
                <div class="published">
                    <p>Set visibility to public</p>
                    <label class="switch">
                        <input type="checkbox" name="is_published" {{ $post->is_published == true ? 'checked' : '' }}>
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
                <input type="hidden" name="category_id" value="{{ isset($post) ? ($post->category ? $post->category->id : 0) : 0 }}"/>
                <div class="edit_post_actions_section">
                    <a href="{{ route('history.index', $post->id) }}" class="history">
                        <i class="fa-solid fa-timeline"></i> History
                    </a>
                </div>
                <div class="create_post_actions">
                    <input type="button" onClick="submitForm();" value="Update">
                    <div class="save" onClick="autoSave();">Save Draft</div>
                </div>
                <div class="auto-save-info">

                </div>
            </div>
        </form>
        <x-select-image />
    </div>
    @if ($hasAutoSave)
        <script type="module">
            detectedAutoSave();
        </script>
    @endif
    <script>
        // Initialize Quill editor
        quill.on('text-change', function() {
            document.getElementById('hiddenArea').value = quill.root.innerHTML;
        });

        // Load existing content
        @if($post->body)
            quill.root.innerHTML = `{!! addslashes($post->body) !!}`;
        @endif

        // Image preview functionality
        document.getElementById('image').addEventListener('change', function(event) {
            if (event.target.files && event.target.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('output').src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            }
        });

        function submitForm() {
            document.getElementById('hiddenArea').value = quill.root.innerHTML;
            document.getElementById('form').submit();
        }
    </script>
</x-admin-layout>
