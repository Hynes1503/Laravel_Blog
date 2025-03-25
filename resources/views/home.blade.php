<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HynesTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid px-5">
                <a class="navbar-brand" href="#">Counter:Side</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">Giới thiệu</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Về chúng tôi</a></li>
                                <li><a class="dropdown-item" href="#">Sứ mệnh</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">Tin tức</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Tin công nghệ</a></li>
                                <li><a class="dropdown-item" href="#">Tin thị trường</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="#" role="button">Chăm sóc khách hàng</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Hỗ trợ</a></li>
                                <li><a class="dropdown-item" href="#">Liên hệ</a></li>
                            </ul>
                        </li>
                    </ul>

                    <style>
                        /* Hiển thị dropdown khi hover */
                        .nav-item.dropdown:hover .dropdown-menu {
                            display: block;
                            position: absolute;
                        }
                    </style>

                    <div class="d-flex me-2">
                        <a href="#" class="mx-2">Facebook</a>
                        <a href="#" class="mx-2">Zalo</a>
                        <a href="#" class="mx-2">Github</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    {{-- content --}}
    <div>
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="..." class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <footer>

    </footer>
</body>

</html>
