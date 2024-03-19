 <div class="mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8  ">
     <div class= "text-white text-2xl font-bold sm:text-3xl ">
         <span class="text-lg">Recently shortened URLs</span>
     </div>
     <div class="mt-4 overflow-hidden shadow sm:rounded-lg ">
         @foreach ($urls as $index => $url)
             <div class="relative bg-gray-100 mt-1 flex-grow text-black border-l-8 border-red-500 rounded-md px-3 py-2">
                 <span class="text-sm sm:text-base">{{ \Illuminate\Support\Str::limit($url->shortened_url, 28, '...') }}</span>
                 <div id="{{ $index }}" data-url="{{ $url->shortened_url }}"
                     class="shortUrl absolute p-2 top-2 right-1 cursor-pointer">
                     @include('icons.clipboard')
                 </div>

                 <div class="text-gray-500 font-thin text-xs sm:text-sm pt-1 overflow-hidden">
                     <span class="inline-flex gap-1 justify-center text-align-center">{{ $url->url }}</span>
                     <br />
                     <span class="inline-flex gap-1 justify-center text-align-center">
                         @include('icons.calendar')
                         {{ $url->expiration_date }}
                     </span>
                     <br />
                     <span class="inline-flex gap-1 justify-center text-align-center">
                         <img width="10rem" sm:width="15rem" height="10rem" sm:height="15rem"
                             src="https://svgsilh.com/svg/481829.svg" alt="Visitors">
                         {{ $url->visits }}
                     </span>
                 </div>
             </div>
         @endforeach
     </div>

     <div class="mt-3">
         {{ $urls->links() }}
     </div>

 </div>


 <script>
    document.querySelectorAll('.shortUrl').forEach(item => {
            item.addEventListener('click', event => {
                const url = item.getAttribute('data-url');
                navigator.clipboard.writeText(url).then(function() {
                    console.log('Async: Copying to clipboard was successful!');
                    item.innerHTML = '<span class="text-green-500 font-bold animate__animated animate__fadeInRight ">Copied!<span>';

                }, function(err) {
                    console.error('Async: Could not copy text: ', err);
                });
            })
    })

 </script>
