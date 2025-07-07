<x-admin-layout>
    <x-dashboard-navbar route="{{ route('home') }}"/>

    <div class="dashboard main">
        <div class="page-header">
            <h1>Contact Messages</h1>
            <p>View and manage contact form submissions</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="contact-messages">
            @if($contacts->count() > 0)
                <div class="messages-list">
                    @foreach($contacts as $contact)
                        <div class="message-item {{ !$contact->is_read ? 'unread' : '' }}">
                            <div class="message-header">
                                <div class="sender-info">
                                    <h3>{{ $contact->name }}</h3>
                                    <p>{{ $contact->email }}</p>
                                </div>
                                <div class="message-meta">
                                    <span class="date">{{ $contact->created_at->format('M j, Y g:i A') }}</span>
                                    @if(!$contact->is_read)
                                        <span class="unread-badge">New</span>
                                    @endif
                                </div>
                            </div>
                            <div class="message-preview">
                                {{ Str::limit($contact->message, 100) }}
                            </div>
                            <div class="message-actions">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary">View</a>
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{ $contacts->links() }}
            @else
                <div class="no-messages">
                    <p>No contact messages yet.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .page-header {
            margin-bottom: 2rem;
        }
        
        .page-header h1 {
            color: var(--primary-600);
            margin-bottom: 0.5rem;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .messages-list {
            space-y: 1rem;
        }
        
        .message-item {
            background: white;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            transition: box-shadow 0.2s;
        }
        
        .message-item:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .message-item.unread {
            border-left: 4px solid var(--primary-600);
            background-color: #f8f9ff;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }
        
        .sender-info h3 {
            margin: 0 0 0.25rem 0;
            color: var(--primary-700);
        }
        
        .sender-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        
        .message-meta {
            text-align: right;
        }
        
        .date {
            display: block;
            color: #888;
            font-size: 0.85rem;
        }
        
        .unread-badge {
            background: var(--primary-600);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: inline-block;
        }
        
        .message-preview {
            color: #555;
            margin-bottom: 1rem;
            line-height: 1.5;
        }
        
        .message-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .btn-primary {
            background: var(--primary-600);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--primary-700);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .no-messages {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
    </style>
</x-admin-layout>
