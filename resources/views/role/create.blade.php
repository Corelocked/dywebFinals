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
                <i class="fas fa-user-shield" style="color: var(--primary-500);"></i>
                Create New Role
            </h1>
            <p style="
                color: var(--text-secondary);
                margin: 0.5rem 0 0 0;
                font-size: 1rem;
            ">Define permissions and access levels for this role</p>
        </div>

        <form action="{{ route('roles.store') }}" method="POST" id="create_role" style="width: 100%;">
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
                        margin-bottom: 0.5rem;
                    ">
                        <i class="fas fa-exclamation-triangle" style="color: var(--error-600);"></i>
                        <span style="color: var(--error-700); font-weight: 600;">Please fix the following errors:</span>
                    </div>
                    <ul style="
                        margin: 0;
                        padding-left: 1.5rem;
                        color: var(--error-600);
                    ">
                        @foreach ($errors->all() as $error)
                            <li style="margin: 0.25rem 0;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Role Name Section -->
            <div style="
                background: var(--surface-elevated);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border: 1px solid var(--border-color);
            ">
                <label for="role_name" style="
                    display: block;
                    color: var(--text-primary);
                    font-weight: 600;
                    margin-bottom: 0.75rem;
                    font-size: 1rem;
                ">
                    <i class="fas fa-tag" style="margin-right: 0.5rem; color: var(--primary-500);"></i>
                    Role Name
                </label>
                <input type="text" name="name" id="role_name" autocomplete="off" value="{{ old('name') }}" required style="
                    width: 100%;
                    padding: 0.875rem 1rem;
                    border: 2px solid var(--border-color);
                    border-radius: 8px;
                    background: var(--surface-primary);
                    color: var(--text-primary);
                    font-size: 1rem;
                    transition: all 0.2s ease;
                    box-sizing: border-box;
                " onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)'" onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none'" placeholder="Enter role name (e.g., Editor, Manager)">
            </div>

            <!-- Permissions Section -->
            <div style="
                background: var(--surface-elevated);
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border: 1px solid var(--border-color);
            ">
                <h3 style="
                    color: var(--text-primary);
                    font-weight: 600;
                    margin: 0 0 1.5rem 0;
                    font-size: 1.125rem;
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                ">
                    <i class="fas fa-shield-alt" style="color: var(--primary-500);"></i>
                    Permissions
                </h3>

                @php $last_label = ''; @endphp
                <div class="permissions-group">
                @foreach ($permissions as $permission)
                    @php $label = explode('-', $permission->name); @endphp
                    @if ($label[0] != $last_label)
                        @if($loop->index != 0)
                                </div>
                            </div>
                        @endif
                        <div style="
                            background: var(--surface-primary);
                            border-radius: 10px;
                            padding: 1.25rem;
                            margin-bottom: 1rem;
                            border: 1px solid var(--border-color);
                        ">
                            <h4 style="
                                color: var(--text-primary);
                                font-weight: 600;
                                margin: 0 0 1rem 0;
                                font-size: 1rem;
                                text-transform: capitalize;
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                            ">
                                <i class="fas fa-cog" style="color: var(--primary-500); font-size: 0.875rem;"></i>
                                {{ ucfirst($label[0]) }} Permissions
                            </h4>
                            <div style="
                                display: grid;
                                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                                gap: 0.75rem;
                            ">
                        @php $last_label = $label[0]; @endphp
                    @endif
                    <label style="
                        display: flex;
                        align-items: center;
                        gap: 0.75rem;
                        padding: 0.75rem;
                        background: var(--surface-secondary);
                        border-radius: 8px;
                        cursor: pointer;
                        transition: all 0.2s ease;
                        border: 1px solid var(--border-color);
                    " onmouseover="this.style.background='var(--primary-50)'; this.style.borderColor='var(--primary-200)'" onmouseout="this.style.background='var(--surface-secondary)'; this.style.borderColor='var(--border-color)'">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" style="
                            width: 18px;
                            height: 18px;
                            accent-color: var(--primary-500);
                            cursor: pointer;
                        ">
                        <span style="
                            color: var(--text-primary);
                            font-weight: 500;
                            font-size: 0.875rem;
                            text-transform: capitalize;
                        ">{{ $label[1] }}{{ isset($label[2]) ? ' ' . $label[2] : '' }}</span>
                    </label>
                    @if($loop->last)
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
            </div>

            <!-- Submit Button -->
            <div style="text-align: center; margin-top: 2rem;">
                <button type="submit" style="
                    background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
                    color: white;
                    border: none;
                    padding: 1rem 2.5rem;
                    border-radius: 12px;
                    font-size: 1rem;
                    font-weight: 600;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(59, 130, 246, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(59, 130, 246, 0.3)'">
                    <i class="fas fa-plus-circle"></i>
                    Create Role
                </button>
            </div>
        </form>
    </div>
</x-main-layout>
