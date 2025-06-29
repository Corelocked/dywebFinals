<div>
    <form method="POST" action="/roles">
        @csrf
        <label for="role_name">Role Name</label>
        <input id="role_name" name="role_name" type="text" />
        <label for="description">Description</label>
        <textarea id="description" name="description" type="text">
        </textarea>
        <button type="submit">Save</button>
        <a href="/index">Back</a>
    </form>
</div>
