<x-main-layout>
    <div class="dashboard">
        <form action="{{ route('users.update', $user->id) }}" method="POST" id="create_user">
            @csrf
            @method('PATCH')
            <div class="welcome-2">Edit User</div>
            <div class="body_form">
                @if(count($errors) > 0)
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                <label>First Name</label>
                <input type="text" name="firstname" autocomplete="off" value="{{ $user->firstname }}">
                <label>Last Name</label>
                <input type="text" name="lastname" autocomplete="off" value="{{ $user->lastname }}">
                <label>Email</label>
                <input type="email" name="email" autocomplete="off" value="{{ $user->email }}">
                <label>Role</label>
                <select name="roles">
                    @isset($roles)
                        @foreach ($roles as $role)
                            @if(isset($userRole[0]) && $userRole[0] == $role)
                                <option value="{{ $role }}" selected>{{ $role }}</option>
                            @else
                                <option value="{{ $role }}">{{ $role }}</option>
                            @endif
                        @endforeach
                    @endisset
                </select>
                <label>Password</label>
                <div id="password_gen">
                    <input type="text" name="password" autocomplete="off">
                    <div class="button" onClick="generatePassword();">Generate</div>
                </div>
                <label>Email</label>
                <div class="mail">
                    <p>Send email after editing account</p>
                    <label class="switch">
                        <input type="checkbox" name="send_mail" checked>
                        <span class="slider round"></span>
                    </label>
                </div>
                <input type="submit" value="Edit">
            </div>
        </form>
    </div>
    <script>
        function generatePassword(){
            var pwdChars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            var pwdLen = 10;
            var randPassword = new Array(pwdLen).fill(0).map(x => (function(chars) { let umax = Math.pow(2, 32), r = new Uint32Array(1), max = umax - (umax % chars.length); do { crypto.getRandomValues(r); } while(r[0] > max); return chars[r[0] % chars.length]; })(pwdChars)).join('');

            const passwordField = document.querySelector('input[name=password]');

            passwordField.value = randPassword;
        }
    </script>
</x-main-layout>
