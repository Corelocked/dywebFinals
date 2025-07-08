<x-main-layout>
    @section('scripts')
        @vite(['resources/js/filtr.js'])
        @vite(['resources/js/image.js'])
    @endsection

    <style>
        /* Reset and use consistent variables from other pages */
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

        /* Page Layout - Match other management pages */
        .page-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Page Header - Consistent with other pages */
        .page-header {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 3rem 2rem;
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

        /* Statistics Cards - Match dashboard style */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-card {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
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

        /* Main Content Layout */
        .content-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        /* Filter Sidebar - Match other management pages */
        .filter-sidebar {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
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
            transition: all 0.3s ease;
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
            transition: transform 0.3s ease;
        }

        .filter-body {
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Filter Sections */
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

        /* Filter Options */
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
            transition: all 0.3s ease;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .filter-option:hover {
            border-color: var(--primary-300);
            background: var(--primary-50);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
        }

        .filter-option.active {
            background: var(--primary-100);
            border-color: var(--primary-500);
            color: var(--primary-700);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.2);
        }

        .filter-option .icon {
            color: var(--neutral-400);
            font-size: 1rem;
            transition: color 0.3s ease;
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

        /* Search Input */
        .search-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background: var(--surface-primary);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
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

        /* Apply Button */
        .apply-filters-btn {
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            border: none;
            font-weight: 700;
            text-align: center;
            margin-top: 1.5rem;
            border-radius: 8px;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 16px rgba(14, 165, 233, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.875rem;
        }

        .apply-filters-btn:hover {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.4);
        }

        /* Image Grid */
        .image-grid {
            background: var(--surface-primary);
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 1.25rem;
            min-height: 400px;
        }

        /* Image Grid - Very Compact Fixed Size Containers */
        .image-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(64px, 1fr)); /* Even smaller grid cells */
            gap: 0.25rem;
            padding: 0;
            width: 100%;
            justify-items: center;
            align-items: start;
        }

        /* Ultra-Compact Image Card Styles */
        .image-card {
            background: var(--surface-primary);
            border-radius: 4px;
            border: 1px solid var(--border-color);
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            overflow: hidden;
            transition: all 0.15s ease;
            cursor: pointer;
            position: relative;
            width: 64px;
            min-width: 64px;
            max-width: 64px;
            height: 80px;
            display: flex;
            flex-direction: column;
        }

        .image-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
            border-color: var(--primary-300);
        }

        .image-card .image-preview {
            width: 100%;
            height: 40px;
            object-fit: cover;
            object-position: center;
            transition: transform 0.15s ease;
            flex-shrink: 0;
            background: var(--surface-secondary);
            display: block;
        }

        .image-card:hover .image-preview {
            transform: scale(1.05);
        }

        .image-card .image-info {
            padding: 0.1rem 0.2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 0;
        }

        .image-card .image-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.5rem;
            margin: 0 0 0.08rem 0;
            word-break: break-word;
            line-height: 1.05;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .image-card .image-details {
            display: flex;
            flex-direction: column;
            gap: 0.05rem;
            margin-bottom: 0.08rem;
        }

        .image-card .detail-item {
            display: flex;
            align-items: center;
            gap: 0.1rem;
            color: var(--text-secondary);
            font-size: 0.4rem;
        }

        .image-card .detail-item i {
            color: var(--primary-500);
            width: 12px;
            text-align: center;
            font-size: 0.65rem;
        }

        .image-card .image-actions {
            display: flex;
            gap: 0.25rem;
            margin-top: auto; /* Push to bottom */
            padding-top: 0.25rem;
            border-top: 1px solid var(--border-color);
        }

        .image-card .action-btn {
            flex: 1;
            padding: 0.2rem 0.3rem;
            border: 1px solid var(--border-color);
            background: var(--surface-primary);
            color: var(--text-secondary);
            border-radius: 3px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.55rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1px;
            text-align: center;
            line-height: 1;
        }

        .image-card .action-btn:hover {
            border-color: var(--primary-400);
            color: var(--primary-600);
            background: var(--primary-50);
        }

        .image-card .action-btn.delete:hover {
            border-color: var(--error-400);
            color: var(--error-600);
            background: rgba(239, 68, 68, 0.1);
        }

        /* Usage Badge - Smaller */
        .image-card .usage-badge {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: var(--primary-500);
            color: white;
            padding: 0.15rem 0.4rem;
            border-radius: 8px;
            font-size: 0.55rem;
            font-weight: 600;
            box-shadow: 0 2px 4px rgba(14, 165, 233, 0.3);
        }

        .image-card .usage-badge.no-usage {
            background: var(--neutral-400);
        }

        /* File Type Badge - Smaller */
        .image-card .file-type-badge {
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 0.15rem 0.3rem;
            border-radius: 3px;
            font-size: 0.5rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.2px;
        }

        /* Pagination Styles */
        .pagination-wrapper {
            margin-top: 2rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .pagination a,
        .pagination span {
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            background: var(--surface-primary);
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            min-width: 44px;
            text-align: center;
        }

        .pagination a:hover {
            border-color: var(--primary-400);
            color: var(--primary-600);
            background: var(--primary-50);
        }

        .pagination .active span {
            background: var(--primary-500);
            color: white;
            border-color: var(--primary-500);
        }

        /* Enhanced Responsive Design - Maintaining Fixed Grid Sizing */
        @media (max-width: 1200px) {
            .image-list {
                grid-template-columns: repeat(auto-fill, 170px);
                gap: 0.75rem;
            }
            
            .image-card {
                height: 210px;
                width: 170px;
            }
            
            .image-card .image-preview {
                height: 95px;
            }
        }

        @media (max-width: 768px) {
            .image-list {
                grid-template-columns: repeat(auto-fill, 160px);
                gap: 0.5rem;
            }
            
            .image-card {
                height: 200px;
                width: 160px;
            }
            
            .image-card .image-preview {
                height: 90px;
            }
            
            .image-card .image-name {
                font-size: 0.7rem;
            }
            
            .image-card .detail-item {
                font-size: 0.6rem;
            }
        }

        @media (max-width: 480px) {
            .image-list {
                grid-template-columns: repeat(auto-fill, 150px);
                gap: 0.5rem;
            }
            
            .image-card {
                height: 190px;
                width: 150px;
            }
            
            .image-card .image-preview {
                height: 85px;
            }
        }
            
            .image-card .image-info {
                padding: 1rem;
            }
        }

        /* Image Modal Styles */
            .image_modal {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.95);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                backdrop-filter: blur(10px);
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .image_modal.active {
                opacity: 1;
                visibility: visible;
            }

            .image_modal .thumbnail {
                max-width: 80vw;
                max-height: 80vh;
                object-fit: contain;
                border-radius: 12px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8);
                transition: transform 0.3s ease;
            }

            .image_modal .close {
                position: fixed;
                top: 2rem;
                right: 2rem;
                width: 48px;
                height: 48px;
                background: var(--surface-primary);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                font-size: 1.5rem;
                color: var(--text-primary);
                transition: all 0.3s ease;
                border: 2px solid var(--border-color);
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                z-index: 10000;
            }

            .image_modal .close:hover {
                background: var(--error-500);
                color: white;
                transform: scale(1.1);
                border-color: var(--error-500);
            }

            .file_info {
                position: fixed;
                top: 2rem;
                left: 2rem;
                background: var(--surface-primary);
                border-radius: 16px;
                padding: 2rem;
                max-width: 350px;
                border: 2px solid var(--border-color);
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                max-height: calc(100vh - 4rem);
                overflow-y: auto;
                z-index: 10000;
            }

            .file_info p, .file_info div {
                color: var(--text-secondary);
                margin: 0.75rem 0;
                font-size: 0.875rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .file_info .filename {
                font-weight: 700;
                font-size: 1.125rem;
                color: var(--text-primary);
                margin: 1rem 0;
                word-break: break-all;
                line-height: 1.4;
            }

            .file_info .directory {
                color: var(--primary-600);
                font-weight: 600;
            }

            .file_info .size {
                color: var(--text-secondary);
                font-weight: 500;
            }

            .file_info .usage_count {
                color: var(--primary-500);
                font-weight: 600;
            }

            .file_info .button {
                background: linear-gradient(135deg, var(--error-500), var(--error-600));
                color: white;
                border: none;
                padding: 0.875rem 1.5rem;
                border-radius: 8px;
                cursor: pointer;
                font-weight: 600;
                margin-top: 1.5rem;
                width: 100%;
                transition: all 0.3s ease;
                font-size: 0.875rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .file_info .button:hover {
                background: linear-gradient(135deg, var(--error-600), var(--error-700));
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(239, 68, 68, 0.4);
            }

            .file_info .use_info {
                color: var(--text-primary);
                font-weight: 700;
                margin-top: 2rem;
                margin-bottom: 1rem;
                padding-bottom: 0.5rem;
                border-bottom: 2px solid var(--border-color);
            }

            .file_info .used {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-top: 1rem;
            }

            .file_info .post {
                display: flex;
                gap: 1rem;
                padding: 1rem;
                background: var(--surface-secondary);
                border-radius: 8px;
                border: 1px solid var(--border-color);
            }

            .file_info .post img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: 6px;
                flex-shrink: 0;
            }

            .file_info .post .info {
                flex: 1;
                min-width: 0;
            }

            .file_info .post .type {
                color: var(--primary-500);
                font-weight: 600;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-bottom: 0.25rem;
            }

            .file_info .post .location {
                color: var(--text-secondary);
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }

            .file_info .post .title {
                color: var(--text-primary);
                font-weight: 600;
                font-size: 0.875rem;
                line-height: 1.3;
                word-break: break-word;
            }

            /* Dark mode adjustments */
        [data-theme="dark"] .filter-option.active {
            background: rgba(14, 165, 233, 0.15);
            border-color: var(--primary-400);
            color: var(--primary-300);
        }

        [data-theme="dark"] .filter-option.active p {
            color: var(--primary-300);
        }

        [data-theme="dark"] .filter-option.active .icon {
            color: var(--primary-400);
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
    <div class="image_modal" style="display: none;">
        <img src="" class="thumbnail" alt="">
        <div class="close" onclick="closeModal();"><i class="fa-solid fa-xmark"></i></div>
        <div class="file_info">
            <p class="directory"><i class="fa-solid fa-folder"></i> <span>Folder:</span></p>
            <div class="filename">Filename</div>
            <div class="size"><i class="fa-solid fa-database"></i> <span>Size: 0</span></div>
            <div class="usage_count"><i class="fa-solid fa-recycle"></i> <span>Used: 0 times</span></div>
            @can('image-delete')
                <button class="button" onclick="deleteImage(event);" data-name="on">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    Delete Image
                </button>
            @endcan
            <div class="use_info">Usage Details:</div>
            <div class="used">
                <div class="post">
                    <img src="" alt="">
                    <div class="info">
                        <div class="type">Post</div>
                        <div class="location">Body</div>
                        <div class="title">Title</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
