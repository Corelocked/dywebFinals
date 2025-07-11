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
            display: flex;
            flex-direction: column;
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Filter bar */
        .filter-bar {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        .filter-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .filter-section-title {
            font-weight: 600;
            color: var(--primary-500);
            font-size: 1rem;
            position: relative;
            padding-left: 1rem;
        }
        .filter-section-title::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 16px;
            background: var(--primary-500);
            border-radius: 2px;
        }
        .filter-options {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
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
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            background: var(--surface-secondary);
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.875rem;
            color: var(--text-secondary);
            min-width: 80px;
        }
        .filter-option:hover {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }
        .filter-option.active {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }
        .filter-option .icon {
            font-size: 0.875rem;
        }
        .filter-option p {
            margin: 0;
            font-weight: 500;
        }
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--surface-secondary);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: var(--surface-primary);
        }
        .search-input::placeholder {
            color: var(--text-secondary);
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

        /* Image grid and cards */
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 1rem;
        }
        
        /* Card Layout */
        .image-card {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }
        
        .image-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-200);
        }
        
        .image-card .image-preview {
            width: 100%;
            height: 240px;
            object-fit: cover;
            background: var(--surface-secondary);
        }
        
        .image-card .image-preview:empty {
            background: linear-gradient(135deg, var(--surface-secondary), var(--primary-50));
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
        }
        
        .image-card .image-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .image-card .image-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            line-height: 1.4;
        }
        .image-card .image-details {
            display: flex;
            flex-direction: column;
            gap: 0.08rem;
            margin-bottom: 0.08rem;
            width: 100%;
        }
        .image-card .image-details {
            display: flex;
            gap: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        
        .image-card .detail-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }
        
        .image-card .detail-item i {
            color: var(--primary-500);
            font-size: 1rem;
        }
        
        .image-card .image-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 1.5rem;
            justify-content: flex-end;
        }
        
        .image-card .action-btn {
            padding: 0.5rem;
            border: none;
            background: var(--surface-secondary);
            color: var(--text-secondary);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
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
            .filter-bar {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 1.5rem;
            }
            .image-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
            <div class="filter-bar">
                <div class="filter-section">
                    <h4 class="filter-section-title">Sort</h4>
                    <div class="filter-options">
                        <div class="filter-option" onclick="filterCheck(1);" data-order="asc">
                            <i class="fa-solid fa-arrow-down-a-z"></i>
                            <p>Name (A-Z)</p>
                        </div>
                        <div class="filter-option" onclick="filterCheck(2);" data-order="desc">
                            <i class="fa-solid fa-arrow-up-z-a"></i>
                            <p>Name (Z-A)</p>
                        </div>
                        <div class="filter-option active" onclick="filterCheck(8);" data-order="descUsage">
                            <i class="fa-solid fa-chart-line"></i>
                            <p>Most Used</p>
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <h4 class="filter-section-title">Search</h4>
                    <input type="text" class="search-input" name="term" value="{{ $terms ?? '' }}" placeholder="Search images...">
                </div>

                <div class="filter-section">
                    <h4 class="filter-section-title">Show:</h4>
                    <div class="filter-options">
                        <div class="filter-option active" onclick="radioCheck(1);">
                            <p>20</p>
                        </div>
                        <div class="filter-option" onclick="radioCheck(2);">
                            <p>50</p>
                        </div>
                        <div class="filter-option" onclick="radioCheck(3);">
                            <p>100</p>
                        </div>
                    </div>
                </div>

                <form style="display: none" id="filter_form">
                    <input type="text" id="term" name="q" value="{{ $terms ?? '' }}">
                    <input type="text" id="order" name="order" value="{{ $order ?? 'descUsage' }}">
                    <input type="text" id="limit" name="limit" value="{{ $limit ?? 20 }}">
                    <input type="text" id="directories" name="directories[]" value="{{ !empty($selected_directories[0]) ? $selected_directories[0] : null }}">
                    <input type="text" id="extensions" name="extensions[]" value="{{ !empty($selected_extensions[0]) ? $selected_extensions[0] : null }}">
                    <input type="text" id="duplicates" name="duplicates[]" value="{{ $duplicates ? implode(',', $duplicates) : '' }}">
                </form>
            </div>
            
            <div class="image-grid">
                @if($files->count() > 0)
                    @foreach($files as $file)
                        <x-image-card :image="$file"/>
                    @endforeach

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
    <div class="image_modal" style="display: none; align-items: center; justify-content: center; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 1000; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px);">
        <div class="modal-content" style="background: var(--surface-primary); border-radius: 20px; box-shadow: 0 12px 48px rgba(0,0,0,0.22); padding: 2.5rem 2rem 2rem 2rem; max-width: 420px; width: 100%; position: relative; margin: auto;">
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
