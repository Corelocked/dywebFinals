<div>
    <form method="POST" action="/roles/{{$role->id}}">
        @method('PUT')
        @csrf
        <label for="role_name">Role Name</label>
        <input id="role_name" name="role_name" type="text" value={{$role->role_name}} />
        <label for="description">Description</label>
        <textarea id="description" name="description" type="text">
            {{$role->description}}
        </textarea>
        <button type="submit">Save</button>
        <a href="/roles">Back</a>
    </form>
</div>
