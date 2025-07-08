<x-main-layout>
    <div class="dashboard create-form" style="
        background: var(--surface-primary);
        border-radius: 16px;
        padding: 2rem;
        max-width: 800px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
    ">
        <div style="
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--primary-100);
        ">
            <h1 style="
                color: var(--text-primary);
                font-size: 2rem;
                font-weight: 700;
                margin: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
            ">
                <i class="fas fa-tags" style="color: var(--primary-500);"></i>
                Create New Category
            </h1>
            <p style="
                color: var(--text-secondary);
                margin: 0.5rem 0 0 0;
                font-size: 1rem;
            ">Design and configure a new category with custom colors</p>
        </div>

        <form action="{{ route('categories.store') }}" method="POST" id="create_category" style="width: 100%;">
            @csrf

            @if ($errors->any())
                <div style="
                    background: var(--error-50);
                    border: 1px solid var(--error-200);
                    border-radius: 12px;
                    padding: 1rem;
                    margin-bottom: 1.5rem;
                ">
                    <div style="
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        margin-bottom: 0.75rem;
                    ">
                        <i class="fas fa-exclamation-triangle" style="color: var(--error-500);"></i>
                        <span style="
                            color: var(--error-700);
                            font-weight: 600;
                            font-size: 0.875rem;
                        ">Please fix the following errors:</span>
                    </div>
                    <ul style="
                        margin: 0;
                        padding-left: 1.5rem;
                        color: var(--error-600);
                        font-size: 0.875rem;
                    ">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Live Preview Section --}}
            <div style="
                background: var(--surface-secondary);
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                text-align: center;
            ">
                <label style="
                    display: block;
                    color: var(--text-primary);
                    font-weight: 600;
                    font-size: 0.875rem;
                    margin-bottom: 1rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                ">Live Preview</label>
                <div id="categoryPreview" style="
                    display: inline-block;
                    padding: 0.75rem 1.5rem;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 1rem;
                    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                    transition: all 0.3s ease;
                    background: {{ old('backgroundColor', '#f1c40f') }};
                    color: {{ old('textColor', '#000000') }};
                ">
                    {{ old('name', 'Category Preview') }}
                </div>
            </div>

            {{-- Form Fields --}}
            <div style="display: grid; gap: 1.5rem;">
                {{-- Category Name --}}
                <div style="display: grid; gap: 0.5rem;">
                    <label for="categoryName" style="
                        color: var(--text-primary);
                        font-weight: 600;
                        font-size: 0.875rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <i class="fas fa-tag" style="color: var(--primary-500);"></i>
                        Category Name
                        <span style="color: var(--error-500);">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name" 
                        id="categoryName" 
                        value="{{ old('name') }}"
                        autocomplete="off"
                        placeholder="Enter category name..."
                        required
                        style="
                            width: 100%;
                            padding: 0.875rem 1rem;
                            border: 2px solid var(--border-color);
                            border-radius: 8px;
                            font-size: 1rem;
                            background: var(--surface-primary);
                            color: var(--text-primary);
                            transition: all 0.3s ease;
                            box-sizing: border-box;
                        "
                        onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                    >
                </div>

                {{-- Color Selection Row --}}
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1.5rem;
                ">
                    {{-- Background Color --}}
                    <div style="display: grid; gap: 0.5rem;">
                        <label for="backgroundColor" style="
                            color: var(--text-primary);
                            font-weight: 600;
                            font-size: 0.875rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        ">
                            <i class="fas fa-palette" style="color: var(--primary-500);"></i>
                            Background Color
                        </label>
                        <div style="
                            position: relative;
                            border: 2px solid var(--border-color);
                            border-radius: 8px;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        ">
                            <input 
                                type="color" 
                                name="backgroundColor" 
                                id="backgroundColor" 
                                value="{{ old('backgroundColor', '#f1c40f') }}"
                                style="
                                    width: 100%;
                                    height: 50px;
                                    border: none;
                                    cursor: pointer;
                                    background: transparent;
                                "
                            >
                        </div>
                    </div>

                    {{-- Text Color --}}
                    <div style="display: grid; gap: 0.5rem;">
                        <label for="textColor" style="
                            color: var(--text-primary);
                            font-weight: 600;
                            font-size: 0.875rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        ">
                            <i class="fas fa-font" style="color: var(--primary-500);"></i>
                            Text Color
                        </label>
                        <div style="
                            position: relative;
                            border: 2px solid var(--border-color);
                            border-radius: 8px;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        ">
                            <input 
                                type="color" 
                                name="textColor" 
                                id="textColor" 
                                value="{{ old('textColor', '#000000') }}"
                                style="
                                    width: 100%;
                                    height: 50px;
                                    border: none;
                                    cursor: pointer;
                                    background: transparent;
                                "
                            >
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div style="
                    display: flex;
                    justify-content: center;
                    padding-top: 1rem;
                    margin-top: 1rem;
                    border-top: 1px solid var(--border-color);
                ">
                    <button 
                        type="submit"
                        style="
                            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
                            color: white;
                            border: none;
                            border-radius: 8px;
                            padding: 0.875rem 2rem;
                            font-size: 1rem;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                            min-width: 160px;
                            justify-content: center;
                        "
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 0, 0, 0.2)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)';"
                    >
                        <i class="fas fa-plus"></i>
                        Create Category
                    </button>
                </div>
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
</x-main-layout>
