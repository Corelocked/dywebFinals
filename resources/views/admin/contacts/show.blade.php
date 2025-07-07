<x-admin-layout>
    <x-dashboard-navbar route="{{ route('home') }}"/>

    <div class="dashboard main">
        <div class="page-header">
            <div class="header-actions">
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">← Back to Messages</a>
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">Delete Message</button>
                </form>
            </div>
        </div>

        <div class="contact-detail">
            <div class="contact-header">
                <h1>Message from {{ $contact->name }}</h1>
                <div class="contact-meta">
                    <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                    <p><strong>Received:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</p>
                    <p><strong>Status:</strong> 
                        <span class="status-badge {{ $contact->is_read ? 'read' : 'unread' }}">
                            {{ $contact->is_read ? 'Read' : 'Unread' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="message-content">
                <h2>Message:</h2>
                <div class="message-text">
                    {{ $contact->message }}
                </div>
            </div>

            <div class="contact-actions">
                <a href="mailto:{{ $contact->email }}?subject=Re: Your Contact Message" class="btn btn-primary">Reply via Email</a>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">Back to All Messages</a>
            </div>
        </div>
    </div>

    <style>
        .page-header {
            margin-bottom: 2rem;
        }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .contact-detail {
            background: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .contact-header h1 {
            color: var(--primary-700);
            margin-bottom: 1.5rem;
        }
        
        .contact-meta {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 2rem;
        }
        
        .contact-meta p {
            margin: 0.5rem 0;
        }
        
        .contact-meta strong {
            color: var(--primary-600);
        }
        
        .contact-meta a {
            color: var(--primary-600);
            text-decoration: none;
        }
        
        .contact-meta a:hover {
            text-decoration: underline;
        }
        
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-badge.read {
            background: #d4edda;
            color: #155724;
        }
        
        .status-badge.unread {
            background: #fff3cd;
            color: #856404;
        }
        
        .message-content h2 {
            color: var(--primary-600);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .message-text {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 6px;
            border-left: 4px solid var(--primary-600);
            line-height: 1.6;
            white-space: pre-wrap;
            margin-bottom: 2rem;
        }
        
        .contact-actions {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e5e5e5;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
        }
        
        .btn-primary {
            background: var(--primary-600);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-700);
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</x-admin-layout>
