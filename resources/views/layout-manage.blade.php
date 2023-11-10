<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="/images/logo.jpeg" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#ef3b2d",
                        },
                    },
                },
            };
        </script>
        <!-- Add these lines to the head section of your HTML file -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-QzgNKs3uJHNOyjFBLVSdnHwCDe3Iv2lVqMuZNmvSZ6E2eVfvVK5k4zm9V6cH51bbAq28tj6X1/BFyjxKfSwBFQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-oLqNSbYtJ0QZpg5uyZp9l5T0ulWhvpZlVDiE2PVcFZU=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-j5vZ4z3GycHXn9pudvbXzT4fTrxHXtsR9OWR9Mgh+6zdHeEJ6G1dCxM1cC8xzhCW0eEohmKFiUL0DWHX6fru4g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <title>OCP | Find Products/Materiels</title>
    </head>
    <body class="mb-48">
        <nav class="flex justify-between items-center mb-4">
                <a href="/"
                    ><img class="w-24" src="{{asset('images/logo.jpeg')}}" alt="" class="logo"
                /></a>
                <ul class="flex space-x-6 mr-6 text-lg">
                    {{-- <li>
                        <a href="/manage/" class="hover:text-laravel"
                            ><i class="fa-solid fa-gear"></i>
                            Dashboard</a
                        >
                    </li> --}}
                    <li>
                        <a href="/manage/material" class="hover:text-laravel"
                            ><i class="fa-solid fa-clipboard-list"></i>
                            Material</a
                        >
                    </li>
                    <li>
                        <a href="/manage/brand" class="hover:text-laravel"
                            ><i class="fa-brands fa-bitcoin"></i>
                            Brand</a
                        >
                    </li>
                    <li>
                        <a href="/manage/category" class="hover:text-laravel"
                            ><i class="fas fa-th-list"></i>
                            Category</a
                        >
                    </li>
  
                    <div x-data="{ open: false }" class="relative inline-flex">
                        <button @click="open = !open" x-bind:class="{ 'hover:text-laravel-active': open}" class="hover:text-laravel hs-dropdown-toggle inline-flex justify-center items-center gap-x-2"><i class="fas fa-shopping-cart"></i>
                            Orders
                            <svg x-bind:class="{ 'rotate-180': open }" class="hs-dropdown-open:rotate-180 w-2.5 h-2.5" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </button>     
                        <ul x-show="open" @click.away="open = false" class="z-20 border border-black rounded-lg absolute left-0 w-[200px] bg-white text-black mt-10 bg-white" x-cloak>
                            <li><a class="block px-4 py-2 hover:bg-gray-200 rounded-lg" href="/manage/orders/add"><i class="fas fa-plus"></i>  Add Order</a></li>
                            <li><a class="block px-4 py-2 hover:bg-gray-200 rounded-lg" href="/manage/orders/manage"><i class="fas fa-cogs"></i>  Manage Order</a></li>
                        </ul>
                    </div> 
                    

                    <li>
                        <form action="/logout" class="inline" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-door-closed"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>

        </nav>
        
        {{-- <nav class="flex justify-between items-center mb-4">
            
            <ul class="flex space-x-6 mr-6 text-lg">
                @auth
                <li>
                    <span class="font-bold uppercase">
                        Welcome {{auth()->user()->name}}
                    </span>
                </li>
                @if(auth()->user()->role == 'admin')
                <li>
                    <a href="/materials/manage" class="hover:text-laravel"
                        ><i class="fa-solid fa-gear"></i>
                        Manage</a
                    >
                </li>
                @endif
                <li>
                    <form action="/logout" class="inline" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-door-closed"></i>Logout
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a href="/register" class="hover:text-laravel"
                        ><i class="fa-solid fa-user-plus"></i> Register</a
                    >
                </li>
                <li>
                    <a href="/login" class="hover:text-laravel"
                        ><i class="fa-solid fa-arrow-right-to-bracket"></i>
                        Login</a
                    >
                </li>
                @endauth
            </ul>
        </nav> --}}
        <main>
            @yield('content')
        </main>
        <footer
            class="fixed bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center"
        >
            <p class="ml-2">Copyright &copy; 2022, All Rights reserved</p>
            @auth
            @if(auth()->check() && auth()->user()->role == 'admin')
            <a
                href="/materials/create"
                class="absolute top-1/3 right-10 bg-black text-white py-2 px-5"
                >Add Materiel</a
            >
            @endif
            @endauth
        </footer>
        <x-flash-message />
        {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> --}}

    </body>
</html>