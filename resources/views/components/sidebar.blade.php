<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0px;
            left: -250px;
            background-color: #343a40;
            color: #fff;
            transition: left 0.3s;
            /* Smooth transition */
            z-index: 1000;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            Color: #ffffff;
            padding: 8px;
            text-decoration: none;
            display: block;
            font-size: 18px;
            text-align: LEFT;
            margin: 0px;
            background-color: #000000;
            margin-bottom: 6px;
            border-top: 0px solid red;
            border-right: 0px solid transparent;
            border-top-right-radius: 60px !important;
            border-bottom-right-radius: 60PX;
            margin-right: 13px;
        }


        .sidebar a:hover {
            background-color: #e7e7e7;
            border-top-right-radius: 60px;
        }

        .sidebar .active {
            background-color: #ffffff;
            border-top-right-radius: 60px;
            color: #000000;
        }

        .sidebar .text-center i {
            color: #007bff;
        }

        .sidebar .text-center h5 {
            color: #fff;
            margin-top: 10px;
        }

        .toggle-btn {
            /* position: fixed; */
            /* top: 20px;*/
            left: 20px;
            background-color: #047c4a;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1001;
        }

        .toggle-btn i {
            font-size: 24px;
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar" style="border-right: 2px solid #10ac56; ">
        <div class="text-center mb-4 " style="border-bottom: 2px solid #10ac56;background-color:white">
            <div class="d-flex justify-content-center pt-3">
                <img src="https://safetycircleindia.com/wp-content/uploads/2024/06/Safety-circle-R-logo-changes.png"
                    alt="" class="w-50 mb-5">
            </div>
        </div>


        <a href="{{ route('Query') }}" class="{{ request()->routeIs('Query') ? 'active' : '' }}">
            <span><i class="fas fa-tachometer-alt"></i> </span>Assigned Queries
        </a>

        <a href="{{ route('toQueries') }}" class="{{ request()->routeIs('toQueries') ? 'active' : '' }}">
            <span><i class="fas fa-tachometer-alt"></i> </span> Initiated Queries

        </a>
    </div>

    <!-- Toggle Button -->


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('toggle-btn').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('app').classList.toggle('sidebarClose');
            document.getElementById('nav-bar').classList.toggle('sidebarClose');
        });
    </script>
</body>

</html>
