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
                <i class="fas fa-user-plus" style="color: var(--primary-500);"></i>
                Create New User
            </h1>
            <p style="
                color: var(--text-secondary);
                margin: 0.5rem 0 0 0;
                font-size: 1rem;
            ">Add a new user account with assigned role and permissions</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" id="create_user" style="width: 100%;">
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
                        margin-bottom: 0.75rem;
                    ">
                        <i class="fas fa-exclamation-triangle" style="color: var(--error-500);"></i>
                        <span style="
                            color: var(--error-700);
                            font-weight: 600;
                            font-size: 0.875rem;
                        ">Please fix the following errors:</span>
                    </div>
                    <ul style="
                        margin: 0;
                        padding-left: 1.5rem;
                        color: var(--error-600);
                        font-size: 0.875rem;
                    ">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: 0.25rem;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: grid; gap: 1.5rem;">
                {{-- Name Fields Row --}}
                <div style="
                    display: grid;
                    grid-template-columns: 1fr 1fr;
                    gap: 1.5rem;
                ">
                    {{-- First Name --}}
                    <div style="display: grid; gap: 0.5rem;">
                        <label for="firstname" style="
                            color: var(--text-primary);
                            font-weight: 600;
                            font-size: 0.875rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        ">
                            <i class="fas fa-user" style="color: var(--primary-500);"></i>
                            First Name
                            <span style="color: var(--error-500);">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="firstname" 
                            id="firstname"
                            value="{{ old('firstname') }}"
                            autocomplete="given-name"
                            placeholder="Enter first name..."
                            required
                            style="
                                width: 100%;
                                padding: 0.875rem 1rem;
                                border: 2px solid var(--border-color);
                                border-radius: 8px;
                                font-size: 1rem;
                                background: var(--surface-primary);
                                color: var(--text-primary);
                                transition: all 0.3s ease;
                                box-sizing: border-box;
                            "
                            onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                        >
                    </div>

                    {{-- Last Name --}}
                    <div style="display: grid; gap: 0.5rem;">
                        <label for="lastname" style="
                            color: var(--text-primary);
                            font-weight: 600;
                            font-size: 0.875rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                        ">
                            <i class="fas fa-user" style="color: var(--primary-500);"></i>
                            Last Name
                            <span style="color: var(--error-500);">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="lastname" 
                            id="lastname"
                            value="{{ old('lastname') }}"
                            autocomplete="family-name"
                            placeholder="Enter last name..."
                            required
                            style="
                                width: 100%;
                                padding: 0.875rem 1rem;
                                border: 2px solid var(--border-color);
                                border-radius: 8px;
                                font-size: 1rem;
                                background: var(--surface-primary);
                                color: var(--text-primary);
                                transition: all 0.3s ease;
                                box-sizing: border-box;
                            "
                            onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                        >
                    </div>
                </div>

                {{-- Email --}}
                <div style="display: grid; gap: 0.5rem;">
                    <label for="email" style="
                        color: var(--text-primary);
                        font-weight: 600;
                        font-size: 0.875rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <i class="fas fa-envelope" style="color: var(--primary-500);"></i>
                        Email Address
                        <span style="color: var(--error-500);">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        placeholder="Enter email address..."
                        required
                        style="
                            width: 100%;
                            padding: 0.875rem 1rem;
                            border: 2px solid var(--border-color);
                            border-radius: 8px;
                            font-size: 1rem;
                            background: var(--surface-primary);
                            color: var(--text-primary);
                            transition: all 0.3s ease;
                            box-sizing: border-box;
                        "
                        onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                    >
                </div>

                {{-- Role --}}
                <div style="display: grid; gap: 0.5rem;">
                    <label for="roles" style="
                        color: var(--text-primary);
                        font-weight: 600;
                        font-size: 0.875rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <i class="fas fa-user-shield" style="color: var(--primary-500);"></i>
                        User Role
                        <span style="color: var(--error-500);">*</span>
                    </label>
                    <select 
                        name="roles" 
                        id="roles"
                        required
                        style="
                            width: 100%;
                            padding: 0.875rem 1rem;
                            border: 2px solid var(--border-color);
                            border-radius: 8px;
                            font-size: 1rem;
                            background: var(--surface-primary);
                            color: var(--text-primary);
                            transition: all 0.3s ease;
                            box-sizing: border-box;
                            cursor: pointer;
                        "
                        onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                        onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                    >
                        <option value="">Select a role...</option>
                        @isset($roles)
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('roles') == $role ? 'selected' : '' }}>{{ $role }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                {{-- Password --}}
                <div style="display: grid; gap: 0.5rem;">
                    <label for="password" style="
                        color: var(--text-primary);
                        font-weight: 600;
                        font-size: 0.875rem;
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                    ">
                        <i class="fas fa-lock" style="color: var(--primary-500);"></i>
                        Password
                        <span style="color: var(--error-500);">*</span>
                    </label>
                    <div style="position: relative; display: flex; gap: 0.5rem;">
                        <input 
                            type="text" 
                            name="password" 
                            id="password"
                            value="{{ old('password') }}"
                            autocomplete="new-password"
                            placeholder="Enter password or generate one..."
                            required
                            style="
                                flex: 1;
                                padding: 0.875rem 1rem;
                                border: 2px solid var(--border-color);
                                border-radius: 8px;
                                font-size: 1rem;
                                background: var(--surface-primary);
                                color: var(--text-primary);
                                transition: all 0.3s ease;
                                box-sizing: border-box;
                            "
                            onfocus="this.style.borderColor='var(--primary-500)'; this.style.boxShadow='0 0 0 3px var(--primary-100)';"
                            onblur="this.style.borderColor='var(--border-color)'; this.style.boxShadow='none';"
                        >
                        <button 
                            type="button" 
                            onclick="generatePassword()"
                            style="
                                background: var(--secondary-500);
                                color: white;
                                border: none;
                                border-radius: 8px;
                                padding: 0.875rem 1rem;
                                font-size: 0.875rem;
                                font-weight: 600;
                                cursor: pointer;
                                transition: all 0.3s ease;
                                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                                display: flex;
                                align-items: center;
                                gap: 0.5rem;
                                white-space: nowrap;
                            "
                            onmouseover="this.style.background='var(--secondary-600)';"
                            onmouseout="this.style.background='var(--secondary-500)';"
                        >
                            <i class="fas fa-random"></i>
                            Generate
                        </button>
                    </div>
                    <small style="
                        color: var(--text-secondary);
                        font-size: 0.75rem;
                        margin-top: 0.25rem;
                    ">Minimum 8 characters recommended</small>
                </div>

                {{-- Send Email Notification --}}
                <div style="
                    background: var(--surface-secondary);
                    border: 1px solid var(--border-color);
                    border-radius: 12px;
                    padding: 1.5rem;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    gap: 1rem;
                ">
                    <div style="flex: 1;">
                        <div style="
                            color: var(--text-primary);
                            font-weight: 600;
                            font-size: 0.875rem;
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                            margin-bottom: 0.25rem;
                        ">
                            <i class="fas fa-envelope" style="color: var(--primary-500);"></i>
                            Email Notification
                        </div>
                        <p style="
                            color: var(--text-secondary);
                            font-size: 0.75rem;
                            margin: 0;
                            line-height: 1.4;
                        ">Send login credentials via email to the new user</p>
                    </div>
                    <label class="switch" style="
                        position: relative;
                        display: inline-block;
                        width: 60px;
                        height: 34px;
                    ">
                        <input type="checkbox" name="send_mail" checked style="
                            opacity: 0;
                            width: 0;
                            height: 0;
                        ">
                        <span class="slider round" style="
                            position: absolute;
                            cursor: pointer;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            background-color: var(--border-color);
                            transition: .4s;
                            border-radius: 34px;
                        "></span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <div style="
                    display: flex;
                    justify-content: center;
                    padding-top: 1rem;
                    margin-top: 1rem;
                    border-top: 1px solid var(--border-color);
                ">
                    <button 
                        type="submit"
                        style="
                            background: linear-gradient(135deg, var(--primary-500), var(--primary-600));
                            color: white;
                            border: none;
                            border-radius: 8px;
                            padding: 0.875rem 2rem;
                            font-size: 1rem;
                            font-weight: 600;
                            cursor: pointer;
                            transition: all 0.3s ease;
                            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                            display: flex;
                            align-items: center;
                            gap: 0.5rem;
                            min-width: 160px;
                            justify-content: center;
                        "
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(0, 0, 0, 0.2)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.15)';"
                    >
                        <i class="fas fa-user-plus"></i>
                        Create User
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        /* Custom toggle switch styles */
        input:checked + .slider {
            background-color: var(--primary-500) !important;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px var(--primary-500);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>

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