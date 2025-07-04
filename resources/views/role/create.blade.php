<x-admin-layout>
    <x-dashboard-navbar route="{{ route('dashboard') }}"/>

    <div class="dashboard">
        <form action="{{ route('roles.store') }}" method="POST" id="create_role">
            <div class="welcome-2">Add Role</div>
            @if($errors->any())
                <ul class="form-errors">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <div class="body_form">
                @csrf
                <label for="role_name">Name</label>
                <input type="text" name="name" id="role_name" autocomplete="off" value="{{ old('name') }}" required>

                @php $last_label = ''; @endphp

                <div class="permissions-group">
                @foreach ($permissions as $permission)
                    @php $label = explode('-', $permission->name); @endphp
                    @if ($label[0] != $last_label)
                        @if($loop->index != 0)
                                </div>
                            </div>
                        @endif
                        <div class="role_container" style="margin-bottom: 18px;">
                            <p class="role_label" style="font-weight: bold; margin-bottom: 6px;">{{ ucfirst($label[0]) }}</p>
                            <div class="permissions" style="display: flex; flex-wrap: wrap; gap: 10px;">
                        @php $last_label = $label[0]; @endphp
                    @endif
                    <label class="container" style="margin-right: 12px;">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                        <span class="checkmark"></span>
                        <span>{{ $label[1] }}{{ isset($label[2]) ? '-' . $label[2] : '' }}</span>
                    </label>
                    @if($loop->last)
                            </div>
                        </div>
                    @endif
                @endforeach
                </div>
                <input type="submit" value="Create" class="button primary-btn" style="margin-top: 18px;">
            </div>
        </form>
    </div>
</x-admin-layout>
