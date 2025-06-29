<div>
    <a href='/roles/create'>Create Role</a>
    <table>
        <th>
            <td>Role Name</td>
            <td>Action</td>
        </th>
        @foreach ($roles as $role)
            <tr>
                <td>{{$role->role_name}}</td>
                <td><a href={{ route('roles.show', $role->id)}}>Show</a></td>
                <td><a href={{ route('roles.edit', $role->id)}}>Edit</a></td>
                <td><form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                onClick="return 
                                    confirm('Are you sure you want to delete this role?')">Delete</button>
                        </form></td>
            </tr>
        @endforeach
    </table>
</div>
