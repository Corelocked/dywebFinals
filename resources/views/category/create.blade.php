<x-admin-layout>
    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="dashboard">
        {{-- Preview Box --}}
        <div id="categoryPreview" style="margin-bottom: 24px; padding: 12px 20px; border-radius: 6px; display: inline-block; font-weight: bold; background: {{ old('backgroundColor', '#f1c40f') }}; color: {{ old('textColor', '#000000') }};">
            {{ old('name', 'Category Preview') }}
        </div>

        <form action="{{ route('categories.store') }}" method="POST" id="create_category">
            @csrf
            <div class="welcome-2">Add category</div>
            @if(count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="body_form">
                <label>Name</label>
                <input type="text" name="name" id="categoryName" autocomplete="off">
                <label for="backgroundColor">Background Color</label>
                <input type="color" name="backgroundColor" id="backgroundColor" value="{{ old('backgroundColor', '#f1c40f') }}">
                <label for="textColor">Text Color</label>
                <input type="color" name="textColor" id="textColor" value="{{ old('textColor', '#000000') }}">
                <input type="submit" value="Create">
            </div>
        </form>
    </div>

    <script>
        const preview = document.getElementById('categoryPreview');
        const nameInput = document.getElementById('categoryName');
        const bgInput = document.getElementById('backgroundColor');
        const textInput = document.getElementById('textColor');

        function updatePreview() {
            preview.textContent = nameInput.value || 'Category Preview';
            preview.style.background = bgInput.value;
            preview.style.color = textInput.value;
        }

        nameInput.addEventListener('input', updatePreview);
        bgInput.addEventListener('input', updatePreview);
        textInput.addEventListener('input', updatePreview);
    </script>
</x-admin-layout>
