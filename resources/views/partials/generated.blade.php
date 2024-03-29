

<div class="w-full mt-4 animate__animated animate__fadeIn">
    <div class="mb-2 flex justify-between items-center">
        <label for="website-url" class="text-sm font-medium text-gray-900 dark:text-white">Your generated link:</label>
    </div>
    <div class="flex items-center ">
        <span class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-s-lg dark:bg-gray-600 dark:text-white dark:border-gray-600">URL</span>
        <div class="relative w-full">
            <input id="generatedUrl" type="text" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-e-0 border-gray-300 text-gray-500 dark:text-gray-400 text-sm border-s-0 focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-red-500 dark:focus:border-red-500" value="{{session('url_generated')}}" readonly disabled />
        </div>
        <button data-tooltip-target="tooltip-website-url" data-copy-to-clipboard-target={{session('url_generated')}} class="flex-shrink-0 z-10 inline-flex items-center py-3 px-4 text-sm font-medium text-center text-white bg-red-700 rounded-e-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 border border-red-700 dark:border-red-600 hover:border-red-800 dark:hover:border-red-700" type="button">
            <span id="default-icon">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                    <path d="M16 1h-3.278A1.992 1.992 0 0 0 11 0H7a1.993 1.993 0 0 0-1.722 1H2a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2Zm-3 14H5a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2Zm0-4H5a1 1 0 0 1 0-2h8a1 1 0 1 1 0 2Zm0-5H5a1 1 0 0 1 0-2h2V2h4v2h2a1 1 0 1 1 0 2Z"/>
                </svg>
            </span>
            <span id="success-icon" class="hidden inline-flex items-center">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
                </svg>
            </span>
        </button>
        <div id="tooltip-website-url" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            <span id="default-tooltip-message">Copy link</span>
            <span id="success-tooltip-message" class="hidden">Copied!</span>
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</div>




<script>

    //copy to clipboard from data-copy-to-clipboard-target
    var element = document.querySelector('[data-copy-to-clipboard-target]');
    var defaultIcon = document.getElementById('default-icon');
    var successIcon = document.getElementById('success-icon');
    var succesTooltip = document.getElementById('success-tooltip-message');

    element.addEventListener('click', function(){
        var value = element.getAttribute('data-copy-to-clipboard-target');
        navigator.clipboard.writeText(value).then(function() {
            console.log('Async: Copying to clipboard was successful!');
            defaultIcon.classList.add('hidden');
            successIcon.classList.remove('hidden');
            succesTooltip.classList.remove('hidden');
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    })


</script>
