
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   {{-- <link rel="icon" href="{{ asset('assets/images/uralogo.png') }}" type="image/png" />--}}
    <title>URASACCOS CRM</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="{{ asset('asset/assets/style.css') }}">

</head>
<body>


    <div class="blur-bg-overlay"></div>
    <div class="form-popup">

        <div class="form-box login">
            <div class="form-details">
                <h2>URASACCOS CRM</h2>
                <p >Customer Relation Management system.</p>
            </div>

            <div class="form-content">
                {{-- <h2>LOGIN</h2> --}}
                <div style="display: flex; justify-content: center;">
                    <a href="index.html">
                         {{--<img src="{{ asset('asset/assets/images/uralogo.png') }}" alt="URASACCOS CRM Logo">--}}
                    </a>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="email" value="{{ old('email') }}" required>
                        <label>Email</label>
                        @error('email')
                            <div style="color: red;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-field">
                        <input type="password" name="password" required>
                        <label>Password</label>
                        @error('password')
                            <div style="color: #ff0000;">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit">Log In</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.body.classList.add("show-popup");
        });


    </script>
</body>
</html>
