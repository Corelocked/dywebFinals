<x-main-layout>
    <div class="email-app">
        <!-- Email App Header -->
        <div class="email-header">
            <div class="email-header-left">
                <h1 class="email-title">
                    <i class="fas fa-inbox"></i>
                    Contact Messages
                </h1>
                <span class="email-count">{{ $contacts->total() }} messages</span>
            </div>
            <div class="email-header-actions">
                <button class="btn-icon" onclick="refreshMessages()" title="Refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
                <button class="btn-icon" onclick="selectAll()" title="Select All">
                    <i class="fas fa-check-square"></i>
                </button>
                <button class="btn-icon btn-danger" onclick="deleteSelected()" title="Delete Selected">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="email-alert success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <!-- Email Sidebar & Content Layout -->
        <div class="email-layout">
            <!-- Email Sidebar -->
            <div class="email-sidebar">
                <div class="email-filters">
                    <h3>Filters</h3>
                    <div class="filter-group">
                        <button class="filter-btn active" data-filter="all">
                            <i class="fas fa-inbox"></i>
                            <span>All Messages</span>
                            <span class="filter-count">{{ $contacts->total() }}</span>
                        </button>
                        <button class="filter-btn" data-filter="unread">
                            <i class="fas fa-envelope"></i>
                            <span>Unread</span>
                            <span class="filter-count">{{ $contacts->where('is_read', false)->count() }}</span>
                        </button>
                        <button class="filter-btn" data-filter="read">
                            <i class="fas fa-envelope-open"></i>
                            <span>Read</span>
                            <span class="filter-count">{{ $contacts->where('is_read', true)->count() }}</span>
                        </button>
                        <button class="filter-btn" data-filter="today">
                            <i class="fas fa-calendar-day"></i>
                            <span>Today</span>
                            <span class="filter-count">{{ $contacts->where('created_at', '>=', today())->count() }}</span>
                        </button>
                        <button class="filter-btn" data-filter="week">
                            <i class="fas fa-calendar-week"></i>
                            <span>This Week</span>
                            <span class="filter-count">{{ $contacts->where('created_at', '>=', now()->startOfWeek())->count() }}</span>
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="email-search">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Search messages..." onkeyup="searchMessages()">
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="email-stats">
                    <h3>Statistics</h3>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-number">{{ $contacts->total() }}</div>
                                <div class="stat-label">Total Messages</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon unread">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-number">{{ $contacts->where('is_read', false)->count() }}</div>
                                <div class="stat-label">Unread</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon today">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-number">{{ $contacts->where('created_at', '>=', today())->count() }}</div>
                                <div class="stat-label">Today</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon week">
                                <i class="fas fa-calendar-week"></i>
                            </div>
                            <div class="stat-info">
                                <div class="stat-number">{{ $contacts->where('created_at', '>=', now()->startOfWeek())->count() }}</div>
                                <div class="stat-label">This Week</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="action-buttons">
                        <button class="quick-btn mark-all-read" onclick="markAllAsRead()">
                            <i class="fas fa-check-double"></i>
                            <span>Mark All Read</span>
                        </button>
                        <button class="quick-btn export-btn" onclick="exportMessages()">
                            <i class="fas fa-download"></i>
                            <span>Export Messages</span>
                        </button>
                        <button class="quick-btn archive-btn" onclick="archiveOld()">
                            <i class="fas fa-archive"></i>
                            <span>Archive Old</span>
                        </button>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="recent-activity">
                    <h3>Recent Activity</h3>
                    <div class="activity-list">
                        @foreach($contacts->take(3) as $recent)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                {{ strtoupper(substr($recent->name, 0, 1)) }}
                            </div>
                            <div class="activity-details">
                                <div class="activity-name">{{ Str::limit($recent->name, 15) }}</div>
                                <div class="activity-time">{{ $recent->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="activity-status">
                                @if(!$recent->is_read)
                                    <div class="status-dot unread"></div>
                                @else
                                    <div class="status-dot read"></div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Email List -->
            <div class="email-content">
                @if($contacts->count() > 0)
                    <div class="email-list" id="emailList">
                        @foreach($contacts as $contact)
                            <div class="email-item {{ !$contact->is_read ? 'unread' : '' }}" 
                                 data-status="{{ $contact->is_read ? 'read' : 'unread' }}"
                                 data-date="{{ $contact->created_at->format('Y-m-d') }}"
                                 data-week="{{ $contact->created_at->isCurrentWeek() ? 'true' : 'false' }}"
                                 data-today="{{ $contact->created_at->isToday() ? 'true' : 'false' }}"
                                 data-search="{{ strtolower($contact->name . ' ' . $contact->email . ' ' . $contact->message) }}">
                                
                                <div class="email-checkbox">
                                    <input type="checkbox" class="message-checkbox" value="{{ $contact->id }}">
                                </div>

                                <div class="email-star">
                                    <i class="far fa-star star-icon" onclick="toggleStar(this)"></i>
                                </div>

                                <div class="email-sender">
                                    <div class="sender-avatar">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                    <div class="sender-details">
                                        <div class="sender-name">{{ $contact->name }}</div>
                                        <div class="sender-email">{{ $contact->email }}</div>
                                    </div>
                                </div>

                                <div class="email-subject">
                                    <div class="subject-line">Contact Form Submission</div>
                                    <div class="email-preview">{{ Str::limit($contact->message, 80) }}</div>
                                </div>

                                <div class="email-date">
                                    <div class="date-text">
                                        @if($contact->created_at->isToday())
                                            {{ $contact->created_at->format('g:i A') }}
                                        @elseif($contact->created_at->isYesterday())
                                            Yesterday
                                        @elseif($contact->created_at->isCurrentWeek())
                                            {{ $contact->created_at->format('l') }}
                                        @else
                                            {{ $contact->created_at->format('M j') }}
                                        @endif
                                    </div>
                                    @if(!$contact->is_read)
                                        <div class="unread-indicator"></div>
                                    @endif
                                </div>

                                <div class="email-actions">
                                    <button class="action-btn" onclick="window.location.href='{{ route('admin.contacts.show', $contact) }}'" title="View">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="action-btn reply-btn" title="Reply" onclick="replyToMessage('{{ $contact->email }}')">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                    <button class="action-btn delete-btn" title="Delete" onclick="deleteMessage({{ $contact->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="email-pagination">
                        {{ $contacts->links() }}
                    </div>
                @else
                    <div class="email-empty">
                        <div class="empty-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <h3>No messages found</h3>
                        <p>When people send contact messages, they'll appear here.</p>
                    </div>
                @endif
        </div>
    </div>

    <style>
        /* Full-screen Gmail-style email app */
        .email-app {
            position: fixed;
            top: var(--space-16); /* 4rem = 64px - Account for navbar height */
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 999;
            width: 100%;
            height: calc(100vh - var(--space-16));
            background: var(--surface-primary);
            border-radius: 0;
            box-shadow: none;
            overflow: hidden;
            margin: 0;
        }

        /* Email Header */
        .email-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2.5rem 3rem;
            background: var(--surface-elevated);
            border-bottom: 1px solid var(--border-color);
            position: relative;
            z-index: 10;
        }

        .email-header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .email-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .email-title i {
            color: var(--primary-500);
        }

        .email-count {
            font-size: 0.875rem;
            color: var(--text-secondary);
            background: var(--surface-muted);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
        }

        .email-header-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: var(--surface-secondary);
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon:hover {
            background: var(--primary-100);
            color: var(--primary-600);
        }

        .btn-icon.btn-danger:hover {
            background: var(--error-100);
            color: var(--error-600);
        }

        /* Email Alert */
        .email-alert {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            background: var(--success-50);
            color: var(--success-700);
            border-bottom: 1px solid var(--success-200);
        }

        /* Email Layout */
        .email-layout {
            display: flex;
            height: calc(100vh - var(--space-16) - 100px); /* Account for navbar + email header */
        }

        /* Email Sidebar */
        .email-sidebar {
            width: 320px;
            background: var(--surface-secondary);
            border-right: 1px solid var(--border-color);
            padding: 1.5rem;
            flex-shrink: 0;
        }

        .email-filters h3 {
            margin: 0 0 1rem 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
            margin-bottom: 2rem;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            width: 100%;
        }

        .filter-btn:hover {
            background: var(--surface-elevated);
        }

        .filter-btn.active {
            background: var(--primary-100);
            color: var(--primary-700);
        }

        .filter-btn i {
            width: 20px;
            color: var(--text-secondary);
        }

        .filter-btn.active i {
            color: var(--primary-600);
        }

        .filter-btn span:first-of-type {
            flex: 1;
        }

        .filter-count {
            font-size: 0.75rem;
            background: var(--surface-muted);
            color: var(--text-secondary);
            padding: 0.125rem 0.5rem;
            border-radius: 50px;
            min-width: 20px;
            text-align: center;
        }

        .filter-btn.active .filter-count {
            background: var(--primary-200);
            color: var(--primary-700);
        }

        /* Search Box */
        .email-search {
            margin-bottom: 2rem;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            color: var(--text-secondary);
            z-index: 1;
        }

        .search-box input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: 25px;
            background: var(--surface-primary);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px var(--primary-100);
        }

        /* Statistics Section */
        .email-stats {
            margin-bottom: 2rem;
        }

        .email-stats h3 {
            margin: 0 0 1rem 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: var(--surface-elevated);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--primary-100);
            color: var(--primary-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.125rem;
        }

        .stat-icon.unread {
            background: var(--warning-100);
            color: var(--warning-600);
        }

        .stat-icon.today {
            background: var(--success-100);
            color: var(--success-600);
        }

        .stat-icon.week {
            background: var(--info-100);
            color: var(--info-600);
        }

        .stat-info {
            flex: 1;
        }

        .stat-number {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 2rem;
        }

        .quick-actions h3 {
            margin: 0 0 1rem 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .quick-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 8px;
            background: var(--surface-elevated);
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
            width: 100%;
            border: 1px solid var(--border-color);
        }

        .quick-btn:hover {
            background: var(--primary-50);
            border-color: var(--primary-200);
            color: var(--primary-700);
        }

        .quick-btn i {
            width: 16px;
            color: var(--text-secondary);
        }

        .quick-btn:hover i {
            color: var(--primary-600);
        }

        /* Recent Activity */
        .recent-activity h3 {
            margin: 0 0 1rem 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .activity-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--surface-elevated);
            border-radius: 10px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .activity-item:hover {
            background: var(--surface-primary);
            border-color: var(--primary-200);
        }

        .activity-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--primary-500);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .activity-details {
            flex: 1;
            min-width: 0;
        }

        .activity-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .activity-time {
            font-size: 0.7rem;
            color: var(--text-secondary);
            margin-top: 0.125rem;
        }

        .activity-status {
            display: flex;
            align-items: center;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-dot.unread {
            background: var(--warning-500);
        }

        .status-dot.read {
            background: var(--success-500);
        }

        /* Email Content */
        .email-content {
            flex: 1;
            overflow: hidden;
        }

        .email-list {
            max-height: calc(100vh - var(--space-16) - 180px); /* Account for navbar + header + pagination */
            overflow-y: auto;
        }

        /* Email Item */
        .email-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.2s ease;
            background: var(--surface-primary);
        }

        .email-item:hover {
            background: var(--surface-elevated);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .email-item.unread {
            background: var(--primary-25);
            border-left: 3px solid var(--primary-500);
        }

        .email-item.unread:hover {
            background: var(--primary-50);
        }

        .email-checkbox {
            margin-right: 1rem;
        }

        .message-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .email-star {
            margin-right: 1rem;
        }

        .star-icon {
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .star-icon:hover,
        .star-icon.starred {
            color: #fbbf24;
        }

        .email-sender {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 200px;
            flex-shrink: 0;
        }

        .sender-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-500);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .sender-details {
            flex: 1;
            min-width: 0;
        }

        .sender-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sender-email {
            font-size: 0.75rem;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .email-subject {
            flex: 1;
            margin: 0 1rem;
            min-width: 0;
        }

        .subject-line {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .email-item.unread .subject-line {
            font-weight: 700;
        }

        .email-preview {
            font-size: 0.75rem;
            color: var(--text-secondary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .email-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 80px;
            flex-shrink: 0;
            justify-content: flex-end;
        }

        .date-text {
            font-size: 0.75rem;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .email-item.unread .date-text {
            font-weight: 600;
            color: var(--text-primary);
        }

        .unread-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary-500);
        }

        .email-actions {
            display: flex;
            gap: 0.25rem;
            opacity: 0;
            transition: opacity 0.2s ease;
            margin-left: 1rem;
        }

        .email-item:hover .email-actions {
            opacity: 1;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .action-btn:hover {
            background: var(--surface-elevated);
            color: var(--text-primary);
        }

        .action-btn.delete-btn:hover {
            background: var(--error-100);
            color: var(--error-600);
        }

        .action-btn.reply-btn:hover {
            background: var(--primary-100);
            color: var(--primary-600);
        }

        /* Email Empty State */
        .email-empty {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 50vh;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .email-empty h3 {
            margin: 0 0 0.5rem 0;
            color: var(--text-primary);
        }

        /* Pagination */
        .email-pagination {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: var(--surface-elevated);
        }

        /* Dark Mode */
        [data-theme="dark"] .email-app {
            background: var(--surface-primary);
        }

        [data-theme="dark"] .email-item.unread {
            background: rgba(59, 130, 246, 0.1);
        }

        [data-theme="dark"] .email-item.unread:hover {
            background: rgba(59, 130, 246, 0.15);
        }

        [data-theme="dark"] .sender-avatar {
            background: var(--primary-600);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .email-sidebar {
                width: 280px;
            }
            
            .email-sender {
                width: 160px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
        }

        @media (max-width: 768px) {
            .email-layout {
                flex-direction: column;
            }
            
            .email-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding: 1rem;
            }
            
            .filter-group {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
                gap: 0.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .action-buttons {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .quick-btn {
                flex: 1;
                min-width: 120px;
            }
            
            .email-item {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            
            .email-sender {
                width: 100%;
            }
            
            .email-subject {
                width: 100%;
                margin: 0;
            }
            
            .email-actions {
                opacity: 1;
                margin-left: 0;
            }

            .activity-list {
                gap: 0.5rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }

        /* Loading States */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--primary-200);
            border-top: 2px solid var(--primary-600);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Enhanced Focus States */
        .filter-btn:focus,
        .quick-btn:focus,
        .search-box input:focus {
            outline: 2px solid var(--primary-500);
            outline-offset: 2px;
        }

        /* Scroll Enhancements */
        .email-list::-webkit-scrollbar {
            width: 8px;
        }

        .email-list::-webkit-scrollbar-track {
            background: var(--surface-secondary);
            border-radius: 4px;
        }

        .email-list::-webkit-scrollbar-thumb {
            background: var(--primary-300);
            border-radius: 4px;
        }

        .email-list::-webkit-scrollbar-thumb:hover {
            background: var(--primary-400);
        }

        /* Hover Effects */
        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }

        .activity-item:hover .activity-avatar {
            transform: scale(1.05);
        }

        /* Status Indicators */
        .email-item.priority-high {
            border-left-color: var(--error-500);
        }

        .email-item.priority-medium {
            border-left-color: var(--warning-500);
        }

        .email-item.priority-low {
            border-left-color: var(--success-500);
        }
    </style>

    <script>
        // Filter functionality
        function filterMessages(filter) {
            const items = document.querySelectorAll('.email-item');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update active button
            buttons.forEach(btn => btn.classList.remove('active'));
            document.querySelector(`[data-filter="${filter}"]`).classList.add('active');
            
            items.forEach(item => {
                let show = false;
                
                switch(filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'unread':
                        show = item.dataset.status === 'unread';
                        break;
                    case 'read':
                        show = item.dataset.status === 'read';
                        break;
                    case 'today':
                        show = item.dataset.today === 'true';
                        break;
                    case 'week':
                        show = item.dataset.week === 'true';
                        break;
                }
                
                item.style.display = show ? 'flex' : 'none';
            });
        }

        // Search functionality
        function searchMessages() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const items = document.querySelectorAll('.email-item');
            
            items.forEach(item => {
                const searchData = item.dataset.search;
                const match = searchData.includes(searchTerm);
                item.style.display = match ? 'flex' : 'none';
            });
        }

        // Add event listeners
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                filterMessages(btn.dataset.filter);
            });
        });

        // Select all functionality
        function selectAll() {
            const checkboxes = document.querySelectorAll('.message-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        }

        // Star toggle
        function toggleStar(element) {
            element.classList.toggle('fas');
            element.classList.toggle('far');
            element.classList.toggle('starred');
        }

        // Delete message
        function deleteMessage(messageId) {
            if (confirm('Are you sure you want to delete this message?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/dashboard/contacts/${messageId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Reply to message
        function replyToMessage(email) {
            window.location.href = `mailto:${email}`;
        }

        // Delete selected
        function deleteSelected() {
            const checked = document.querySelectorAll('.message-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select messages to delete.');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${checked.length} message(s)?`)) {
                // Implement bulk delete functionality
                console.log('Deleting messages:', Array.from(checked).map(cb => cb.value));
            }
        }

        // Refresh messages
        function refreshMessages() {
            window.location.reload();
        }

        // Mark all as read
        function markAllAsRead() {
            if (confirm('Mark all messages as read?')) {
                // Implement mark all as read functionality
                fetch('/dashboard/contacts/mark-all-read', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while marking messages as read.');
                });
            }
        }

        // Export messages
        function exportMessages() {
            const confirmed = confirm('Export all contact messages to CSV?');
            if (confirmed) {
                window.location.href = '/dashboard/contacts/export';
            }
        }

        // Archive old messages
        function archiveOld() {
            const confirmed = confirm('Archive messages older than 30 days?');
            if (confirmed) {
                fetch('/dashboard/contacts/archive-old', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`${data.count} messages archived successfully.`);
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while archiving messages.');
                });
            }
        }

        // Update stats in real-time
        function updateStats() {
            const allItems = document.querySelectorAll('.email-item');
            const unreadItems = document.querySelectorAll('.email-item.unread');
            const todayItems = document.querySelectorAll('.email-item[data-today="true"]');
            const weekItems = document.querySelectorAll('.email-item[data-week="true"]');

            // Update filter counts
            document.querySelector('[data-filter="all"] .filter-count').textContent = allItems.length;
            document.querySelector('[data-filter="unread"] .filter-count').textContent = unreadItems.length;
            document.querySelector('[data-filter="read"] .filter-count').textContent = allItems.length - unreadItems.length;
            document.querySelector('[data-filter="today"] .filter-count').textContent = todayItems.length;
            document.querySelector('[data-filter="week"] .filter-count').textContent = weekItems.length;

            // Update stat cards
            const statCards = document.querySelectorAll('.stat-number');
            if (statCards.length >= 4) {
                statCards[0].textContent = allItems.length;
                statCards[1].textContent = unreadItems.length;
                statCards[2].textContent = todayItems.length;
                statCards[3].textContent = weekItems.length;
            }
        }

        // Initialize tooltips and enhance interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth animations
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('fade-in-up');
            });

            // Update stats on page load
            updateStats();

            // Add keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 'r':
                            e.preventDefault();
                            refreshMessages();
                            break;
                        case 'a':
                            e.preventDefault();
                            selectAll();
                            break;
                        case 'f':
                            e.preventDefault();
                            document.getElementById('searchInput').focus();
                            break;
                    }
                }
            });
        });
    </script>
</x-main-layout>
