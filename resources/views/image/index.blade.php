<x-main-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
        @vite(['resources/js/image.js'])
    @endsection

    <style>
        /* Theme variables (inherits from other pages) */
        :root {
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --surface-primary: #ffffff;
            --surface-secondary: #f8fafc;
            --surface-hover: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-tertiary: #94a3b8;
            --border-color: #e2e8f0;
            --error-500: #ef4444;
            --error-600: #dc2626;
            --error-700: #b91c1c;
            --neutral-400: #9ca3af;
        }
        [data-theme="dark"] {
            --surface-primary: #1e293b;
            --surface-secondary: #334155;
            --surface-hover: #475569;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-tertiary: #94a3b8;
            --border-color: #475569;
        }

        /* Page container and header (matches other pages) */
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }
        .page-header {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 3rem 2rem 2rem 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }
        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 1rem 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .page-header h1 i {
            color: var(--primary-500);
            font-size: 2rem;
        }
        .page-header p {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin: 0 auto;
            max-width: 600px;
            line-height: 1.6;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0 0 0;
        }
        .stat-card {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.13);
        }
        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-500);
            display: block;
            margin-bottom: 0.5rem;
        }
        .stat-card .stat-label {
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Main content layout */
        .content-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Sidebar (filters) */
        .filter-sidebar {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 2rem;
            overflow: hidden;
        }
        .filter-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 2rem;
            border-bottom: 2px solid var(--primary-100);
            cursor: pointer;
            transition: all 0.3s;
        }
        .filter-header:hover {
            background: var(--surface-hover);
        }
        .filter-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .filter-header h3::before {
            content: "🔍";
            font-size: 1.25rem;
        }
        .filter-toggle {
            color: var(--primary-500);
            font-size: 1.25rem;
            transition: transform 0.3s;
        }
        .filter-body {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .filter-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .filter-section-title {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 1rem;
            margin: 0 0 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .filter-section-title::before {
            width: 4px;
            height: 20px;
            background: var(--primary-500);
            content: "";
            border-radius: 2px;
        }
        .filter-options {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .filter-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            border-radius: 8px;
            background: var(--surface-primary);
            border: 2px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.875rem;
            text-decoration: none;
        }
        .filter-option:hover {
            border-color: var(--primary-300);
            background: var(--primary-50);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.12);
        }
        .filter-option.active {
            background: var(--primary-100);
            border-color: var(--primary-500);
            color: var(--primary-700);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.18);
        }
        .filter-option .icon {
            color: var(--neutral-400);
            font-size: 1rem;
            transition: color 0.3s;
            min-width: 16px;
        }
        .filter-option.active .icon {
            color: var(--primary-500);
        }
        .filter-option p {
            margin: 0;
            color: var(--text-secondary);
            font-weight: 500;
            line-height: 1.4;
        }
        .filter-option.active p {
            color: var(--primary-700);
            font-weight: 600;
        }
        .search-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--surface-primary);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 4px var(--primary-100);
            transform: translateY(-2px);
        }
        .search-input::placeholder {
            color: var(--text-tertiary);
        }
        .apply-filters-btn {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border: none;
            font-weight: 700;
            text-align: center;
            margin-top: 1.5rem;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.22);
            transition: all 0.3s;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }
        .apply-filters-btn:hover {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.32);
        }

        /* Image grid and cards (strict, modern, fixed size) */
        .image-grid {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 1.25rem;
            min-height: 400px;
        }
        .image-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(64px, 64px));
            gap: 0.5rem;
            padding: 0.2rem 0.1rem 0.2rem 0.1rem;
            width: 100%;
            justify-content: flex-start;
            align-items: start;
        }
        /* New Card Layout */
        .image-card, .image-card * {
            box-sizing: border-box !important;
            min-width: 0 !important;
            overflow: hidden;
        }
        .image-card {
            background: var(--surface-primary);
            border-radius: 18px;
            border: 1.5px solid var(--border-color);
            box-shadow: 0 4px 24px 0 rgba(59,130,246,0.10), 0 1.5px 4px rgba(0,0,0,0.08);
            overflow: visible;
            transition: box-shadow 0.22s cubic-bezier(.4,2,.6,1), transform 0.22s cubic-bezier(.4,2,.6,1);
            cursor: pointer;
            position: relative;
            width: 90px !important;
            min-width: 90px !important;
            max-width: 90px !important;
            height: 120px !important;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 0.5rem 0.3rem 0.7rem 0.3rem;
        }
        .image-card:hover {
            transform: scale(1.08) translateY(-4px);
            box-shadow: 0 16px 40px 0 rgba(59,130,246,0.18), 0 4px 16px rgba(0,0,0,0.13);
            z-index: 2;
        }
        .image-card .image-preview {
            width: 64px;
            height: 64px;
            object-fit: cover;
            object-position: center;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--surface-secondary) 60%, var(--primary-50) 100%);
            box-shadow: 0 2px 8px rgba(59,130,246,0.10);
            border: 1px solid var(--border-color);
            display: block;
        }
        .image-card .image-preview:empty {
            background: repeating-linear-gradient(135deg, var(--surface-secondary), var(--primary-100) 10px, var(--surface-secondary) 20px);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neutral-400);
            font-size: 1.2rem;
        }
        .image-card .image-info {
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(2.5px) saturate(1.1);
            border-radius: 10px;
            margin-top: 0.2rem;
            width: 100%;
            padding: 0.18rem 0.18rem 0.12rem 0.18rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 0;
            box-shadow: 0 1px 4px rgba(59,130,246,0.06);
        }
        [data-theme="dark"] .image-card .image-info {
            background: rgba(30,41,59,0.98);
        }
        .image-card .image-name {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 0.72rem;
            margin: 0 0 0.08rem 0;
            word-break: break-word;
            line-height: 1.1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            letter-spacing: 0.01em;
        }
        .image-card .image-details {
            display: flex;
            flex-direction: column;
            gap: 0.08rem;
            margin-bottom: 0.08rem;
            width: 100%;
        }
        .image-card .detail-item {
            display: flex;
            align-items: center;
            gap: 0.11rem;
            color: var(--text-secondary);
            font-size: 0.54rem;
            font-weight: 500;
        }
        .image-card .detail-item i {
            color: var(--primary-500);
            width: 12px;
            text-align: center;
            font-size: 0.7rem;
        }
        .image-card .image-actions {
            display: flex;
            gap: 0.12rem;
            margin-top: 0.12rem;
            justify-content: flex-end;
            width: 100%;
        }
        .image-card .action-btn {
            flex: 0 0 20px;
            width: 20px;
            height: 20px;
            padding: 0;
            border: none;
            background: transparent;
            color: var(--text-tertiary);
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        .image-card .action-btn:hover {
            background: var(--primary-100);
            color: var(--primary-600);
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.10);
        }
        .image-card .action-btn.delete:hover {
            background: var(--error-500);
            color: #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.18);
        }
        .image-card .action-btn[title]:hover:after {
            content: attr(title);
            position: absolute;
            bottom: 120%;
            left: 50%;
            transform: translateX(-50%);
            background: var(--surface-primary);
            color: var(--text-primary);
            padding: 0.18rem 0.5rem;
            border-radius: 6px;
            font-size: 0.55rem;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            z-index: 10;
        }
        .image-card .usage-badge {
            position: absolute;
            top: 0.2rem;
            right: 0.2rem;
            background: linear-gradient(90deg, var(--primary-500) 70%, var(--primary-400) 100%);
            color: white;
            padding: 0.09rem 0.45rem;
            border-radius: 999px;
            font-size: 0.54rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.13);
            letter-spacing: 0.03em;
        }
        .image-card .usage-badge.no-usage {
            background: linear-gradient(90deg, var(--neutral-400) 70%, var(--surface-hover) 100%);
            color: var(--text-primary);
        }
        .image-card .file-type-badge {
            position: absolute;
            top: 0.2rem;
            left: 0.2rem;
            background: rgba(0, 0, 0, 0.72);
            color: white;
            padding: 0.09rem 0.35rem;
            border-radius: 999px;
            font-size: 0.48rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }
        .empty-state {
            text-align: center;
            color: var(--text-tertiary);
            padding: 3rem 0;
        }
        .empty-state i {
            font-size: 3rem;
            color: var(--primary-200);
            margin-bottom: 1rem;
        }
        .empty-state h3 {
            color: var(--text-primary);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .empty-state p {
            color: var(--text-secondary);
            font-size: 1rem;
        }
        /* Responsive: sidebar collapses, grid scrolls horizontally if needed */
        @media (max-width: 900px) {
            .content-layout {
                grid-template-columns: 1fr;
            }
            .filter-sidebar {
                position: static;
                margin-bottom: 2rem;
            }
            .image-list {
                overflow-x: auto;
                grid-auto-flow: column;
                grid-template-columns: repeat(auto-fit, minmax(64px, 64px));
            }
        }
        @media (max-width: 600px) {
            .page-container {
                padding: 0.5rem;
            }
            .page-header {
                padding: 1.5rem 0.5rem 1rem 0.5rem;
            }
            .filter-header, .filter-body {
                padding: 1rem;
            }
            .image-grid {
                padding: 0.5rem;
            }
        }
    </style>
    
    <div class="page-container">
        <div class="page-header">
            <h1>
                <i class="fas fa-images"></i>
                Image Management
            </h1>
            <p>Manage and organize your uploaded images with advanced filtering and search capabilities</p>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">
                        @if(method_exists($files, 'total'))
                            {{ $files->total() }}
                        @else
                            {{ $files->count() ?? 0 }}
                        @endif
                    </span>
                    <span class="stat-label">Total Images</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ $files->count() ?? 0 }}</span>
                    <span class="stat-label">Visible</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">{{ isset($extensions) ? count($extensions) : 0 }}</span>
                    <span class="stat-label">Formats</span>
                </div>
                <div class="stat-card">
                    @php
                        $totalSize = 0;
                        if (isset($files)) {
                            foreach ($files as $file) {
                                if (is_array($file) && isset($file['size'])) {
                                    $totalSize += $file['size'];
                                } elseif (is_object($file) && isset($file->size)) {
                                    $totalSize += $file->size;
                                }
                            }
                        }
                    @endphp
                    <span class="stat-number">{{ round($totalSize / 1024 / 1024, 1) }}</span>
                    <span class="stat-label">MB Used</span>
                </div>
            </div>
        </div>

        <div class="content-layout">
            <div class="filter-sidebar">
                <div class="filter-header">
                    <h3>Filters</h3>
                    <i class="fa-solid fa-caret-up filter-toggle"></i>
                </div>
                <div class="filter-body">
                    <div class="filter-section">
                        <h4 class="filter-section-title">Sorting Options</h4>
                        <div class="filter-options">
                            <div class="filter-option" onclick="filterCheck(1);" data-order="asc">
                                <span class="icon"><i class="fa-solid fa-circle-dot"></i></span>
                                <p>Name (A-Z)</p>
                            </div>
                            <div class="filter-option" onclick="filterCheck(2);" data-order="desc">
                                <span class="icon"><i class="fa-solid fa-circle-dot"></i></span>
                                <p>Name (Z-A)</p>
                            </div>
                            <div class="filter-option" onclick="filterCheck(5);" data-order="ascSize">
                                <span class="icon"><i class="fa-solid fa-circle-dot"></i></span>
                                <p>Size (Small to Large)</p>
                            </div>
                            <div class="filter-option" onclick="filterCheck(6);" data-order="descSize">
                                <span class="icon"><i class="fa-solid fa-circle-dot"></i></span>
                                <p>Size (Large to Small)</p>
                            </div>
                            <div class="filter-option active" onclick="filterCheck(8);" data-order="descUsage">
                                <span class="icon"><i class="fa-solid fa-circle-check"></i></span>
                                <p>Usage (High to Low)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <h4 class="filter-section-title">Search Images</h4>
                        <input type="text" class="search-input" name="term" value="{{ $terms ?? '' }}" placeholder="Search by filename...">
                    </div>
                    
                    <div class="filter-section">
                        <h4 class="filter-section-title">Items Per Page</h4>
                        <div class="filter-options">
                            <div class="filter-option active" onclick="radioCheck(1);">
                                <span class="icon"><i class="fa-solid fa-square-check"></i></span>
                                <p>20 items</p>
                            </div>
                            <div class="filter-option" onclick="radioCheck(2);">
                                <span class="icon"><i class="fa-regular fa-square"></i></span>
                                <p>50 items</p>
                            </div>
                            <div class="filter-option" onclick="radioCheck(3);">
                                <span class="icon"><i class="fa-regular fa-square"></i></span>
                                <p>100 items</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <h4 class="filter-section-title">Folders</h4>
                        <div class="filter-options">
                            @foreach ($directories as $directory => $count)
                                @if (isset($selected_directories_array) && in_array($directory, $selected_directories_array))
                                    <div class="filter-option active" onclick="selectDirectory(event, '{{ $directory }}')" data-directory-name="{{ $directory }}">
                                        <span class="icon"><i class="fa-solid fa-square-check"></i></span>
                                        <p>{{ $directory }} ({{ $count }})</p>
                                    </div>
                                @else
                                    <div class="filter-option" onclick="selectDirectory(event, '{{ $directory }}')" data-directory-name="{{ $directory }}">
                                        <span class="icon"><i class="fa-regular fa-square"></i></span>
                                        <p>{{ $directory }} ({{ $count }})</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="filter-section">
                        <h4 class="filter-section-title">File Types</h4>
                        <div class="filter-options">
                            @foreach ($extensions as $extension => $count)
                                @if (isset($selected_extensions_array) && in_array($extension, $selected_extensions_array))
                                    <div class="filter-option active" onclick="selectExtension(event, '{{ $extension }}')" data-extension-name="{{ $extension }}">
                                        <span class="icon"><i class="fa-solid fa-square-check"></i></span>
                                        <p>.{{ $extension }} ({{ $count }})</p>
                                    </div>
                                @else
                                    <div class="filter-option" onclick="selectExtension(event, '{{ $extension }}')" data-extension-name="{{ $extension }}">
                                        <span class="icon"><i class="fa-regular fa-square"></i></span>
                                        <p>.{{ $extension }} ({{ $count }})</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <button class="apply-filters-btn">
                        Apply Filters
                    </button>
                    
                    <form style="display: none" id="filter_form">
                        <input type="text" id="term" name="q" value="{{ $terms ?? '' }}">
                        <input type="text" id="order" name="order" value="{{ $order ?? 'descUsage' }}">
                        <input type="text" id="limit" name="limit" value="{{ $limit ?? 20 }}">
                        <input type="text" id="directories" name="directories[]" value="{{ !empty($selected_directories[0]) ? $selected_directories[0] : null }}">
                        <input type="text" id="extensions" name="extensions[]" value="{{ !empty($selected_extensions[0]) ? $selected_extensions[0] : null }}">
                        <input type="text" id="duplicates" name="duplicates[]" value="{{ $duplicates ? implode(',', $duplicates) : '' }}">
                    </form>
                </div>
            </div>
            
            <div class="image-grid">
                @if($files->count() > 0)
                    <div class="image-list">
                        @php
                            function formatBytes($bytes, $precision = 2) {
                                $kilobyte = 1024;
                                $megabyte = $kilobyte * 1024;

                                if ($bytes < $kilobyte) {
                                    return $bytes . ' B';
                                } elseif ($bytes < $megabyte) {
                                    return number_format($bytes / $kilobyte, $precision) . ' KB';
                                } else {
                                    return number_format($bytes / $megabyte, $precision) . ' MB';
                                }
                            }
                        @endphp
                        
                        @foreach($files as $file)
                            <x-image-card :image="$file"/>
                        @endforeach
                    </div>

                    @if ((int)$limit !== 0)
                        {{ $files->appends([
                             'q' => $terms ?? '',
                             'order' => $order ?? 'descUsage',
                             'limit' => $limit ?? 20,
                             'directories' => !empty($selected_directories) ? $selected_directories : null,
                             'extensions' => !empty($selected_extensions) ? $selected_extensions : null,
                             'duplicates' => $duplicates ? implode(',', $duplicates) : ''
                        ])->links('pagination.default') }}
                    @endif
                @else
                    <div class="empty-state">
                        <i class="fas fa-images"></i>
                        <h3>No images found</h3>
                        <p>Try adjusting your filters or upload some images to get started</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Keep existing modal HTML at the end -->
    <img src="" class="background" alt="" style="display: none;">
    <!-- New Modal Design -->
    <div class="image_modal" style="display: none; align-items: flex-start;">
        <div class="modal-content" style="background: var(--surface-primary); border-radius: 20px; box-shadow: 0 12px 48px rgba(0,0,0,0.22); padding: 2.5rem 2rem 2rem 2rem; max-width: 420px; width: 100%; position: relative; margin: 3vh auto;">
            <div class="close" onclick="closeModal();" style="position: absolute; top: 1.2rem; right: 1.2rem; width: 44px; height: 44px; background: var(--surface-hover); border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.5rem; color: var(--text-primary); border: 2px solid var(--border-color); box-shadow: 0 4px 16px rgba(0,0,0,0.10); z-index: 10000; transition: all 0.2s;">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 1.5rem;">
                <img src="" class="thumbnail" alt="" style="max-width: 220px; max-height: 220px; object-fit: contain; border-radius: 14px; box-shadow: 0 8px 32px rgba(0,0,0,0.13); border: 1.5px solid var(--border-color); background: var(--surface-secondary);" />
                <div class="file_info" style="width: 100%; background: none; border: none; box-shadow: none; padding: 0; max-width: none;">
                    <div class="filename" style="font-weight: 700; font-size: 1.25rem; color: var(--text-primary); margin-bottom: 0.5rem; word-break: break-all; text-align: center;">Filename</div>
                    <div style="display: flex; justify-content: center; gap: 1.2rem; margin-bottom: 1.2rem;">
                        <div class="directory" style="color: var(--primary-600); font-weight: 600; display: flex; align-items: center; gap: 0.4rem;"><i class="fa-solid fa-folder"></i> <span>Folder:</span></div>
                        <div class="size" style="color: var(--text-secondary); font-weight: 500; display: flex; align-items: center; gap: 0.4rem;"><i class="fa-solid fa-database"></i> <span>Size: 0</span></div>
                        <div class="usage_count" style="color: var(--primary-500); font-weight: 600; display: flex; align-items: center; gap: 0.4rem;"><i class="fa-solid fa-recycle"></i> <span>Used: 0 times</span></div>
                    </div>
                    @can('image-delete')
                        <button class="button" onclick="deleteImage(event);" data-name="on" style="background: linear-gradient(135deg, var(--error-500), var(--error-600)); color: white; border: none; padding: 0.9rem 1.7rem; border-radius: 10px; cursor: pointer; font-weight: 700; margin: 1.2rem 0 0.5rem 0; width: 100%; transition: all 0.2s; font-size: 1rem; text-transform: uppercase; letter-spacing: 0.5px; display: flex; align-items: center; justify-content: center; gap: 0.7rem;">
                            <i class="fa-solid fa-trash" aria-hidden="true"></i>
                            Delete Image
                        </button>
                    @endcan
                    <div class="use_info" style="color: var(--text-primary); font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid var(--border-color); text-align: left;">Usage Details:</div>
                    <div class="used" style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                        <div class="post" style="display: flex; gap: 1rem; padding: 1rem; background: var(--surface-secondary); border-radius: 8px; border: 1px solid var(--border-color); align-items: center;">
                            <img src="" alt="" style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px; flex-shrink: 0;" />
                            <div class="info" style="flex: 1; min-width: 0;">
                                <div class="type" style="color: var(--primary-500); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.25rem;">Post</div>
                                <div class="location" style="color: var(--text-secondary); font-size: 0.85rem; margin-bottom: 0.5rem;">Body</div>
                                <div class="title" style="color: var(--text-primary); font-weight: 600; font-size: 1rem; line-height: 1.3; word-break: break-word;">Title</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
