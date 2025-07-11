<x-main-layout>
    <div class="message-viewer">
        <!-- Header with Actions -->
        <div class="message-header">
            <div class="header-content">
                <div class="header-left">
                    <a href="{{ route('admin.contacts.index') }}" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Messages</span>
                    </a>
                    <div class="message-subject">
                        <h1>Contact Form Submission</h1>
                        <span class="message-id">#{{ $contact->id }}</span>
                    </div>
                </div>
                <div class="header-actions">
                    <button class="action-btn reply-btn" onclick="replyToMessage('{{ $contact->email }}')">
                        <i class="fas fa-reply"></i>
                        <span>Reply</span>
                    </button>
                    <button class="action-btn archive-btn">
                        <i class="fas fa-archive"></i>
                        <span>Archive</span>
                    </button>
                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash"></i>
                            <span>Delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="message-content">
            <div class="content-container">
                <!-- Sender Information Card -->
                <div class="sender-card">
                    <div class="sender-avatar">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div class="sender-info">
                        <div class="sender-details">
                            <h2 class="sender-name">{{ $contact->name }}</h2>
                            <p class="sender-email">
                                <i class="fas fa-envelope"></i>
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </p>
                        </div>
                        <div class="message-meta">
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                <span>{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-day"></i>
                                <span>{{ $contact->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="status-badge {{ $contact->is_read ? 'read' : 'unread' }}">
                                    <i class="fas fa-{{ $contact->is_read ? 'check-circle' : 'envelope' }}"></i>
                                    {{ $contact->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="message-body">
                    <div class="message-header-info">
                        <h3>
                            <i class="fas fa-comment-alt"></i>
                            Message Content
                        </h3>
                        <div class="message-stats">
                            <span class="char-count">{{ strlen($contact->message) }} characters</span>
                            <span class="word-count">{{ str_word_count($contact->message) }} words</span>
                        </div>
                    </div>
                    
                    <div class="message-text">
                        {{ $contact->message }}
                    </div>
                </div>

                <!-- Quick Actions Panel -->
                <div class="quick-actions-panel">
                    <h3>
                        <i class="fas fa-bolt"></i>
                        Quick Actions
                    </h3>
                    <div class="actions-grid">
                        <button class="quick-action-btn reply-action" onclick="replyToMessage('{{ $contact->email }}')">
                            <div class="action-icon">
                                <i class="fas fa-reply"></i>
                            </div>
                            <div class="action-info">
                                <span class="action-title">Reply via Email</span>
                                <span class="action-desc">Send a response to {{ $contact->name }}</span>
                            </div>
                        </button>

                        <button class="quick-action-btn forward-action" onclick="forwardMessage()">
                            <div class="action-icon">
                                <i class="fas fa-share"></i>
                            </div>
                            <div class="action-info">
                                <span class="action-title">Forward Message</span>
                                <span class="action-desc">Share this message with someone</span>
                            </div>
                        </button>

                        <button class="quick-action-btn mark-action" onclick="toggleReadStatus({{ $contact->id }})">
                            <div class="action-icon">
                                <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'check' }}"></i>
                            </div>
                            <div class="action-info">
                                <span class="action-title">Mark as {{ $contact->is_read ? 'Unread' : 'Read' }}</span>
                                <span class="action-desc">Change read status</span>
                            </div>
                        </button>

                        <button class="quick-action-btn print-action" onclick="window.print()">
                            <div class="action-icon">
                                <i class="fas fa-print"></i>
                            </div>
                            <div class="action-info">
                                <span class="action-title">Print Message</span>
                                <span class="action-desc">Print or save as PDF</span>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Related Messages (if any) -->
                <div class="related-messages">
                    <h3>
                        <i class="fas fa-history"></i>
                        Recent Messages from {{ $contact->name }}
                    </h3>
                    <div class="related-list">
                        <!-- This would show other messages from the same email -->
                        <div class="no-related">
                            <i class="fas fa-inbox"></i>
                            <span>No other messages from this sender</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Message Viewer - Full Width Layout */
        .message-viewer {
            min-height: 100vh;
            width: 100%;
            background: var(--surface-primary);
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* Override any inherited constraints */
            max-width: none !important;
        }

        /* Reset any container constraints for message viewer */
        body:has(.message-viewer) {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* Ensure no inherited width constraints */
        .message-viewer * {
            box-sizing: border-box;
        }

        /* Message Header */
        .message-header {
            background: var(--surface-elevated);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(10px);
            width: 100%;
            margin: 0;
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex: 1;
        }

        .back-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            background: var(--surface-secondary);
            color: var(--text-primary);
            text-decoration: none;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .back-btn:hover {
            background: var(--primary-50);
            border-color: var(--primary-200);
            color: var(--primary-700);
            transform: translateY(-1px);
        }

        .back-btn i {
            font-size: 0.875rem;
        }

        .message-subject h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.25rem 0;
        }

        .message-id {
            font-size: 0.875rem;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 10px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .reply-btn {
            background: var(--primary-100);
            color: var(--primary-700);
            border: 1px solid var(--primary-200);
        }

        .reply-btn:hover {
            background: var(--primary-600);
            color: white;
            transform: translateY(-1px);
        }

        .archive-btn {
            background: var(--warning-100);
            color: var(--warning-700);
            border: 1px solid var(--warning-200);
        }

        .archive-btn:hover {
            background: var(--warning-600);
            color: white;
        }

        .delete-btn {
            background: var(--error-100);
            color: var(--error-700);
            border: 1px solid var(--error-200);
        }

        .delete-btn:hover {
            background: var(--error-600);
            color: white;
        }

        /* Message Content */
        .message-content {
            padding: 2rem 0;
            width: 100%;
        }

        .content-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* Sender Card */
        .sender-card {
            background: var(--surface-elevated);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .sender-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .sender-info {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
        }

        .sender-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
        }

        .sender-email {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .sender-email a {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 500;
        }

        .sender-email a:hover {
            text-decoration: underline;
        }

        .message-meta {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-end;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .meta-item i {
            color: var(--primary-500);
            width: 16px;
        }

        .status-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-badge.read {
            background: var(--success-100);
            color: var(--success-700);
        }

        .status-badge.unread {
            background: var(--warning-100);
            color: var(--warning-700);
        }

        /* Message Body */
        .message-body {
            background: var(--surface-elevated);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .message-header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .message-header-info h3 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .message-header-info i {
            color: var(--primary-500);
        }

        .message-stats {
            display: flex;
            gap: 1.5rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .message-text {
            background: var(--surface-primary);
            padding: 2rem;
            border-radius: 16px;
            border-left: 4px solid var(--primary-500);
            line-height: 1.8;
            white-space: pre-wrap;
            color: var(--text-primary);
            font-size: 1rem;
            border: 1px solid var(--border-color);
        }

        /* Quick Actions Panel */
        .quick-actions-panel {
            background: var(--surface-elevated);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .quick-actions-panel h3 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0 0 1.5rem 0;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .quick-actions-panel h3 i {
            color: var(--primary-500);
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1rem;
        }

        .quick-action-btn {
            display: flex;
            gap: 1rem;
            padding: 1.5rem;
            background: var(--surface-primary);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: left;
        }

        .quick-action-btn:hover {
            background: var(--primary-50);
            border-color: var(--primary-200);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--primary-100);
            color: var(--primary-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .quick-action-btn:hover .action-icon {
            background: var(--primary-600);
            color: white;
        }

        .action-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .action-title {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1rem;
        }

        .action-desc {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Related Messages */
        .related-messages {
            background: var(--surface-elevated);
            border-radius: 20px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .related-messages h3 {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0 0 1.5rem 0;
            font-size: 1.25rem;
            color: var(--text-primary);
        }

        .related-messages h3 i {
            color: var(--primary-500);
        }

        .no-related {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 2rem;
            background: var(--surface-muted);
            border-radius: 12px;
            color: var(--text-secondary);
            justify-content: center;
            text-align: center;
        }

        .no-related i {
            font-size: 1.5rem;
            opacity: 0.5;
        }

        /* Dark Mode Support */
        [data-theme="dark"] .message-viewer {
            background: var(--surface-primary);
        }

        [data-theme="dark"] .sender-card,
        [data-theme="dark"] .message-body,
        [data-theme="dark"] .quick-actions-panel,
        [data-theme="dark"] .related-messages {
            background: var(--surface-elevated);
        }

        [data-theme="dark"] .sender-avatar {
            background: linear-gradient(135deg, var(--primary-600), var(--primary-700));
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .header-content {
                padding: 0 1.5rem;
            }

            .content-container {
                padding: 0 1.5rem;
            }

            .sender-info {
                flex-direction: column;
                gap: 1rem;
            }

            .message-meta {
                align-items: flex-start;
            }

            .actions-grid {
                grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                padding: 0 1rem;
            }

            .header-left {
                width: 100%;
                justify-content: space-between;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .content-container {
                padding: 0 1rem;
                gap: 1.5rem;
            }

            .sender-card {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .sender-info {
                align-items: center;
                text-align: center;
            }

            .message-header-info {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .message-stats {
                justify-content: center;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .message-header {
                padding: 1rem 0;
            }

            .header-actions {
                gap: 0.5rem;
            }

            .action-btn {
                padding: 0.625rem 1rem;
                font-size: 0.8rem;
            }

            .action-btn span {
                display: none;
            }

            .sender-card,
            .message-body,
            .quick-actions-panel,
            .related-messages {
                padding: 1.5rem;
            }

            .sender-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .quick-action-btn {
                padding: 1rem;
            }

            .action-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        /* Print Styles */
        @media print {
            .message-header,
            .quick-actions-panel,
            .related-messages {
                display: none;
            }

            .message-viewer {
                background: white;
            }

            .sender-card,
            .message-body {
                background: white;
                border: 1px solid #ddd;
                box-shadow: none;
            }
        }
    </style>

    <script>
        // Reply to message
        function replyToMessage(email) {
            const subject = encodeURIComponent('Re: Your Contact Message');
            window.location.href = `mailto:${email}?subject=${subject}`;
        }

        // Forward message
        function forwardMessage() {
            const messageText = document.querySelector('.message-text').textContent;
            const subject = encodeURIComponent('Fwd: Contact Form Submission');
            const body = encodeURIComponent(`\n\n--- Forwarded Message ---\n\n${messageText}`);
            window.location.href = `mailto:?subject=${subject}&body=${body}`;
        }

        // Toggle read status
        function toggleReadStatus(contactId) {
            fetch(`/dashboard/contacts/${contactId}/toggle-read`, {
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
                alert('An error occurred while updating the message status.');
            });
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'r':
                        e.preventDefault();
                        const email = document.querySelector('.sender-email a').getAttribute('href').replace('mailto:', '');
                        replyToMessage(email);
                        break;
                    case 'p':
                        e.preventDefault();
                        window.print();
                        break;
                    case 'Backspace':
                        e.preventDefault();
                        window.history.back();
                        break;
                }
            }
        });

        // Mark as read when page loads (if unread)
        document.addEventListener('DOMContentLoaded', function() {
            const isUnread = document.querySelector('.status-badge.unread');
            if (isUnread) {
                // Auto-mark as read after 2 seconds
                setTimeout(() => {
                    const contactId = {{ $contact->id }};
                    toggleReadStatus(contactId);
                }, 2000);
            }
        });
    </script>
</x-main-layout>
