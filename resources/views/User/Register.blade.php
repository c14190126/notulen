<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link
        href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900"
        rel="stylesheet"
    />

    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="css/style.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #343434;
        }

        .wrapper {
            max-width: 350px;
            min-height: 350px;
            margin: 80px auto;
            padding: 40px 30px 30px 30px;
            background-color: #ecf0f3;
            border-radius: 15px;
        }

        .wrapper .name {
            font-weight: 600;
            font-size: 1.4rem;
            letter-spacing: 1.3px;
            padding-left: 10px;
            color: #555;
        }

        .wrapper .form-field input {
            width: 100%;
            display: block;
            border: none;
            outline: none;
            background: none;
            font-size: 1.2rem;
            color: #666;
            padding: 10px 15px 10px 10px;
        }

        .wrapper .form-field {
            padding-left: 10px;
            margin-bottom: 20px;
            border-radius: 20px;
            box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff;
        }

        .wrapper .form-field .fas {
            color: #555;
        }

        .wrapper .btn {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: #FECF5B;
            color: white;
            border-radius: 25px;
            letter-spacing: 1.3px;
        }

        .wrapper .btn:hover {
            background-color: #ffb700;
        }

        .wrapper .btnz {
            box-shadow: none;
            width: 100%;
            height: 40px;
            background-color: skyblue;
            color: white;
            border-radius: 25px;
            box-shadow: 3px 3px 3px #b1b1b1,
                -3px -3px 3px #fff;
            letter-spacing: 1.3px;
        }

        @media(max-width: 380px) {
            .wrapper {
                margin: 30px 20px;
                padding: 40px 15px 15px 15px;
            }
        }
    </style>
</head>


<body>
    <div class="wrapper">
        {{-- @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif --}}
        <div class="text-center mt-4 name" style="font-weight: bold;">
            Register
        </div>
        <br>
        <form class="p-3 mt-3" action="{{ url('/register') }}" method="post">
            @csrf
            <div class="form-field d-flex align-items-center">
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nama Lengkap" autofocus required value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-field d-flex align-items-center">
                <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Email" autofocus required value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-field d-flex align-items-center">
                <input type="password" name="password" id="password" placeholder="Password" required autofocus>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <input style="margin-left: 5px;" type="checkbox" onclick="myFunction()"> Show Password
            <br> <br>
            <button class="btn mt-3" type="submit">Register</button>
        </form>
    </div>
</body>

<script>
    function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
    }
    </script>

</html>
