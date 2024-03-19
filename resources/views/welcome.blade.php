<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <title>{{ env('APP_NAME') }}</title>
    <style>
        body {
            font-family: 'Nunito';
        }

        .noise {

            background:
                radial-gradient(circle at -54% -150%, rgba(17, 24, 39, 1), rgba(17, 24, 39, 0.8), rgba(163, 23, 23, 0.6)),
                url(https://grainy-gradients.vercel.app/noise.svg);

        }
    </style>

</head>

<body class="bg-gray-900 noise">

    <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 ">
        <div class="mx-auto max-w-lg bg-gray-900 rounded-lg">
            <h1 class="text-center text-2xl font-bold text-red-600 sm:text-3xl">Shorten your url</h1>

            <p class="mx-auto mt-4 max-w-md text-center text-gray-300">
                Shorten your long URL into a much shorter one. Paste your long URL below to shorten it.
            </p>

            <form method="POST" action="/" class="mb-0 mt-6 space-y-4 rounded-lg p-4 bg-gray-800 sm:p-6 lg:p-8">
                @csrf

                @if (session('error'))
                    @include('partials.error')
                @endif


                <p class="text-start text-lg font-medium text-white">Drop your URL</p>
                <div>
                    <div class="relative">
                        <input type="text" id="large-input" name="url" placeholder="Enter URL"
                            class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-smtext-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-base focus:ring-red-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>

                <label for="shorteners"
                    class="mt-2 block mb-2 text-sm sm:text-base font-medium text-gray-900 dark:text-white">Select method
                    to short</label>
                <select name="shorteners" id="shorteners"
                    class="mt-1 bg-gray-50 border border-gray-300 text-gray-900 text-sm sm:text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach ($shortener_methods as $shortener_method)
                        <option value="{{ $shortener_method }}">{{ $shortener_method }}</option>
                    @endforeach
                </select>

                <button type="submit"
                    class="block w-full rounded-lg bg-red-600 px-5 py-3 text-sm font-medium text-white">
                    Submit
                </button>

                @if (session('url_generated'))
                    @include('partials.generated')
                @endif
            </form>

        </div>



    </div>

    @include('partials.list')




</body>

</html>
