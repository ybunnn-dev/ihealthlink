<x-guest-layout>
    @section('title', 'iHealthLink | Login')
    <!-- Fluid Background Egg Shape (45% of screen height) -->
    <div class="hidden lg2:block fixed top-0 left-1/2 transform -translate-x-1/2 w-full h-[38vh] xl3:h-[48vh] bg-mainblue rounded-b-[100%] scale-x-125 -z-10"></div>

    <!-- Main Content -->
    <div class="relative z-10 min-h-screen grid grid-cols-1 lg2:grid-cols-2 items-stretch overflow-hidden">

        <!-- Left Side: Logo and Login -->
        <div class="flex flex-col justify-center lg2:justify-start gap-y-fluid-gap-col px-4 slg:px-6 lg:pl-24 xl3:pl-40 lg:pr-24 xl3:pr-40 py-fluid-vert-pad">
            <!-- Top Logo -->
            <div class="flex items-center gap-fluid-1 mb-fluid-gap-col gap-2 justify-center lg2:justify-start">
                <svg class="w-8 xs:w-9 sm:w-10 text-mainblue lg2:text-f7" viewBox="0 0 90 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.418 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.033 6.37349 76.6026 6.12197L74.001 4.60244Z" fill="currentColor"/>
                </svg>
                <h1 class="text-fluid-md xs:text-fluid-xl font-semibold lg:text-fluid-xl lg:pl-2">
                    <span class="text-maingreen lg2:text-f7">iHealth</span><span class="text-mainblue lg2:text-f7">Link</span>
                </h1>
            </div>
            <!-- Login Form -->
            <div class="w-full max-w-md mx-auto lg:mx-0 bg-f7 rounded-xl slg:rounded-2xl shadow px-4 py-4 slg:py-8 slg:px-8 border border-gray-200 justify-center lg2:justify-start">    
                <div class="text-center mb-4 xs:mb-5 slg:mb-6">
                    <h2 class="text-xl lg:text-2xl xl3:text-fluid-2xl font-semibold text-main_font mb-2 slg:mb-3">SIGN IN</h2>
                    <p class="text-normal_font text-xs xl3:text-sm" >Welcome back! Please sign in to continue.</p>               
                 </div>
                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-xs xs:text-sm text-green-600 bg-green-50 p-3 rounded-lg">
                        {{ $value }}
                    </div>
                @endsession

                <form method="POST" action="{{ route('login') }}" class="space-y-4 xs:space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block font-medium text-main_font mb-1 slg:mb-2 text-xs xl3:text-sm">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full px-3 xs:px-4 py-1 xs:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-mainblue focus:border-mainblue text-gray-900 placeholder-gray-400 text-xs xl2:text-sm"
                            placeholder="your@email.com" />
                    </div>

                  <div class="relative">
                        <label for="password" class="block font-medium text-main_font mb-1 slg:mb-2 text-xs xl3:text-sm">Password</label>
                        <input id="password" name="password" type="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-mainblue focus:border-mainblue text-gray-900 placeholder-gray-400 text-xs xl2:text-sm" placeholder="••••••••" />
                        
                        <div class="absolute inset-y-0 right-0 top-7 pr-3 flex items-center">
                            <input type="checkbox" id="togglePassword" class="hidden"/>
                            <label for="togglePassword" class="cursor-pointer">
                                <svg id="eye-open" class="w-4 h-4 xl2:w-6 xl2:h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                               <svg id="eye-slashed" class="w-4 h-4 xl2:w-6 xl2:h-6 text-gray-500 hidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z"/>
                                    <path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z"/>
                                </svg>
                            </label>
                        </div>
                    </div>
                   <div class="flex flex-col xs:flex-row xs:items-center xs:justify-between gap-2 flex-row items-center ">
                        <label for="remember_me" class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox"
                                class="h-3 xs:h-4 w-3 xs:w-4 text-mainblue focus:ring-mainblue border-gray-300 rounded" />
                            <span class="ml-2 text-gray-700 text-fluid-xs xl:text-xs">Remember me for 30 days</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-mainblue hover:text-blue-700 font-medium text-fluid-xs xl:text-xs">
                                Forgot Password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-mainblue hover:bg-blue-600 text-white font-medium py-2 xs:py-2.5 px-4 text-xs slg:text-sm rounded-lg transition">
                        SIGN IN
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Side Info -->
        <div class="hidden lg2:flex flex-col justify-end items-end pr-[clamp(4rem,12vw,12rem)] pl-[clamp(1rem,4vw,4rem)] py-fluid-vert-pad">
            <div class="max-w-[40ch] text-right space-y-3 text-gray-600">
                <!-- Logo with icon -->
               <div class="flex items-center gap-3 mb-2">
                    <svg class="lg:w-16 lg:h-16 w-16 h-16 text-mainblue" viewBox="0 0 90 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M51.9356 40.3515L53.3692 43.9599L55.1231 40.496L58.2998 34.2206L60.3291 39.4364L60.7637 40.5517H81.9961L63.7647 57.5917C60.6229 60.528 56.8727 62.5495 52.8945 63.6601C44.0894 66.5725 33.8877 64.7375 26.8428 58.1532L8.01173 40.5517H39.8457L40.3545 39.6923L47.126 28.2489L51.9356 40.3515ZM7.32619 6.84755C17.0951 -2.28239 32.9335 -2.28265 42.7022 6.84755L45.0029 8.99892L47.2969 6.85537C57.0658 -2.27458 72.9042 -2.27483 82.6729 6.85537C91.4744 15.0821 92.3439 27.9135 85.2842 37.0517H63.1572L60.1406 29.2987L58.7197 25.6454L56.9492 29.1425L53.7539 35.4511L49.0635 23.6435L47.7471 20.33L45.9307 23.3983L37.8496 37.0517H4.71974C-2.34671 27.9128 -1.47841 15.0767 7.32619 6.84755ZM74.001 4.60244C72.8714 3.94228 71.4536 3.98197 70.3828 4.704C68.3681 6.06262 68.5602 9.01338 70.7383 10.1659L71.6865 10.6679C71.895 10.7782 72.0928 10.9067 72.2783 11.0507L72.9492 11.5712C75.03 13.1867 76.5836 15.3508 77.418 17.7958L77.9024 19.2138C77.9673 19.4041 78.0145 19.5998 78.0449 19.7977L78.1113 20.2284C78.4751 22.6001 81.2939 23.7962 83.3125 22.4354C84.3704 21.7221 84.8944 20.4725 84.6533 19.2372L84.1406 16.6142C84.0465 16.1322 83.9036 15.6595 83.7129 15.204L83.2529 14.1044C82.2107 11.6147 80.5883 9.38565 78.5137 7.59267L77.8135 6.98818C77.4382 6.66391 77.033 6.37349 76.6026 6.12197L74.001 4.60244Z" fill="currentColor"/>
                    </svg>
                   <div class="flex flex-col items-start">
                        <h2 class="text-fluid-2xl font-semibold">
                            <span class="text-maingreen">iHealth</span><span class="text-mainblue">Link</span>
                        </h2>
                        <p class="text-xs font-medium text-darkblue -mt-2">Barangay Healthcare Management System</p>
                    </div>
                </div>         
                <p class="text-[0.75rem] text-justify">
                    Welcome to iHealthLink — your centralized platform for overseeing and managing community healthcare. Seamlessly monitor barangay activities, streamline health campaigns, and coordinate with your barangay health workers in real time.
                </p>
                <p class="text-[0.75rem] text-justify">
                    Gain valuable insights through accessible data and reports to make informed decisions. Empower your team, enhance service delivery, and strengthen community health efforts with ease.
                </p>
            </div>
        </div>
    </div>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordCheckbox = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('eye-open');
        const eyeSlashed = document.getElementById('eye-slashed');

        togglePasswordCheckbox.addEventListener('change', function() {
            if (this.checked) {
                // Show password
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeSlashed.classList.remove('hidden');
            } else {
                // Hide password
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeSlashed.classList.add('hidden');
            }
        });
    </script>
</x-guest-layout>