<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 Page not found</title>

    <!-- Bootstrap CSS (Optional, for grid support) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/404.css') }}">
</head>

<body>
    <section class="page_404">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="four_zero_four_bg">
                        <h1 class="text-center">404</h1>
                    </div>

                    <div class="content_box_404">
                        <h3 class="h2">Looks like you're lost</h3>
                        <p>The page you are looking for is not available!</p>
                        <a href="{{ url()->previous() }}" class="link_404">Go Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
