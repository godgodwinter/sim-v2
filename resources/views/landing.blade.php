<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" href="/assets/landing/favicon.c4b2bf5a.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>G App</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <!-- <link
      href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    /> -->
    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <!-- Custom style -->

    <!-- Poppins font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
      .loading {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        display: flex;
        z-index: 9000000000000;
        overflow: hidden;
      }
      .loading .left {
        background-color: white;
        width: 100%;
        height: 100%;
      }
      .loading .right {
        background-color: white;
        width: 100%;
        height: 100%;
      }
      .loading .logo {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .loading .logo svg {
        height: 50vh;
      }
    </style>
  <script type="module" crossorigin src="/assets/landing/index.26888def111121.js"></script>
  <link rel="modulepreload" href="/assets/landing/vendor.153f79af.js">
  <link rel="stylesheet" href="/assets/landing/index.22a6d9f6.css">
</head>
  <body style="overflow-x: hidden">
    <!-- Loading -->
    <div class="loading">
      <div class="left"></div>
      <div class="right"></div>
      <div class="logo">
        <svg viewBox="0 0 101 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M5.3137 38.6863C-0.934685 44.9347 -0.934685 55.0653 5.3137 61.3137L39.2548 95.2548C45.5032 101.503 55.6339 101.503 61.8822 95.2548L95.8234 61.3137C102.072 55.0653 102.072 44.9347 95.8234 38.6863L61.8822 4.74517C55.6339 -1.50322 45.5032 -1.50322 39.2548 4.74517L5.3137 38.6863ZM35.936 69.608C39.44 73.016 44.336 74.72 50.624 74.72C54.8 74.72 58.424 73.928 61.496 72.344C64.568 70.712 66.92 68.432 68.552 65.504C70.184 62.576 71 59.144 71 55.208V48.296C71 47.768 70.832 47.36 70.496 47.072C70.208 46.736 69.824 46.568 69.344 46.568H53.072C52.592 46.568 52.184 46.736 51.848 47.072C51.56 47.408 51.416 47.816 51.416 48.296V50.6C51.416 51.128 51.56 51.56 51.848 51.896C52.184 52.184 52.592 52.328 53.072 52.328H63.872V55.352C63.872 59.768 62.672 63.08 60.272 65.288C57.872 67.496 54.656 68.6 50.624 68.6C46.64 68.6 43.52 67.52 41.264 65.36C39.008 63.152 37.784 59.744 37.592 55.136C37.544 53.696 37.52 51.56 37.52 48.728C37.52 45.848 37.544 43.712 37.592 42.32C37.784 37.76 39.008 34.4 41.264 32.24C43.52 30.08 46.64 29 50.624 29C54.08 29 56.816 29.768 58.832 31.304C60.896 32.84 62.288 34.688 63.008 36.848C63.2 37.376 63.392 37.736 63.584 37.928C63.824 38.072 64.184 38.144 64.664 38.144H68.912C69.344 38.144 69.704 38.024 69.992 37.784C70.28 37.544 70.424 37.232 70.424 36.848V36.704C70.328 34.832 69.536 32.816 68.048 30.656C66.56 28.496 64.328 26.672 61.352 25.184C58.424 23.648 54.848 22.88 50.624 22.88C44.384 22.88 39.512 24.584 36.008 27.992C32.504 31.4 30.632 36.056 30.392 41.96C30.344 43.352 30.32 45.608 30.32 48.728C30.32 51.8 30.344 54.056 30.392 55.496C30.632 61.448 32.48 66.152 35.936 69.608Z"
            fill="#8B5CF6"
          />
        </svg>
      </div>
    </div>

    <div x-data="mainState" class="overflow-x-hidden" :class="{ dark: isDark }">
      <div class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-800 dark:text-gray-200">
        <!-- Navbar -->
        <nav
          x-data="navbarState"
          class="fixed inset-x-0 bottom-0 z-20 transition-all duration-500 md:top-0 md:bottom-auto"
          :class="{ 'shadow-t-lg md:shadow-lg bg-white dark:bg-gray-700 translate-y-full md:-translate-y-full':
        scrollingDown,
        'shadow-t-lg md:shadow-lg bg-white dark:bg-gray-700': scrollingUp }"
        >
          <div
            class="relative flex flex-row-reverse items-center justify-between p-4 mx-auto bg-white  max-w-7xl md:flex-row md:h-24 md:bg-transparent dark:bg-gray-700 md:dark:bg-transparent"
            :class="{ 'shadow-t-lg': isMobileMenuOpen }"
          >
            <!-- Mobile menu button -->
            <button @click="toggleMobileMenu" class="md:hidden">
              <span class="sr-only">Toggle navigation menu</span>
              <svg
                aria-hidden="true"
                class="w-8 h-8"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <!-- Menu icon path -->
                <path x-show="!isMobileMenuOpen" d="M4 6H20V8H4zM8 11H20V13H8zM13 16H20V18H13z"></path>
                <!-- X icon path -->
                <path
                  x-show="isMobileMenuOpen"
                  d="M16.192 6.344L11.949 10.586 7.707 6.344 6.293 7.758 10.535 12 6.293 16.242 7.707 17.656 11.949 13.414 16.192 17.656 17.606 16.242 13.364 12 17.606 7.758z"
                ></path>
              </svg>
            </button>

            <!-- Logo -->
            <a href="#" class="inline-block rounded-md">
              <span class="sr-only">G App home</span>
              <svg
                aria-hidden="true"
                class="w-10 h-auto text-purple-500 md:w-12"
                viewBox="0 0 101 100"
                fill="currentColor"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M5.3137 38.6863C-0.934685 44.9347 -0.934685 55.0653 5.3137 61.3137L39.2548 95.2548C45.5032 101.503 55.6339 101.503 61.8822 95.2548L95.8234 61.3137C102.072 55.0653 102.072 44.9347 95.8234 38.6863L61.8822 4.74517C55.6339 -1.50322 45.5032 -1.50322 39.2548 4.74517L5.3137 38.6863ZM35.936 69.608C39.44 73.016 44.336 74.72 50.624 74.72C54.8 74.72 58.424 73.928 61.496 72.344C64.568 70.712 66.92 68.432 68.552 65.504C70.184 62.576 71 59.144 71 55.208V48.296C71 47.768 70.832 47.36 70.496 47.072C70.208 46.736 69.824 46.568 69.344 46.568H53.072C52.592 46.568 52.184 46.736 51.848 47.072C51.56 47.408 51.416 47.816 51.416 48.296V50.6C51.416 51.128 51.56 51.56 51.848 51.896C52.184 52.184 52.592 52.328 53.072 52.328H63.872V55.352C63.872 59.768 62.672 63.08 60.272 65.288C57.872 67.496 54.656 68.6 50.624 68.6C46.64 68.6 43.52 67.52 41.264 65.36C39.008 63.152 37.784 59.744 37.592 55.136C37.544 53.696 37.52 51.56 37.52 48.728C37.52 45.848 37.544 43.712 37.592 42.32C37.784 37.76 39.008 34.4 41.264 32.24C43.52 30.08 46.64 29 50.624 29C54.08 29 56.816 29.768 58.832 31.304C60.896 32.84 62.288 34.688 63.008 36.848C63.2 37.376 63.392 37.736 63.584 37.928C63.824 38.072 64.184 38.144 64.664 38.144H68.912C69.344 38.144 69.704 38.024 69.992 37.784C70.28 37.544 70.424 37.232 70.424 36.848V36.704C70.328 34.832 69.536 32.816 68.048 30.656C66.56 28.496 64.328 26.672 61.352 25.184C58.424 23.648 54.848 22.88 50.624 22.88C44.384 22.88 39.512 24.584 36.008 27.992C32.504 31.4 30.632 36.056 30.392 41.96C30.344 43.352 30.32 45.608 30.32 48.728C30.32 51.8 30.344 54.056 30.392 55.496C30.632 61.448 32.48 66.152 35.936 69.608Z"
                />
              </svg>
            </a>

            <!-- Navigation links -->
            <ul class="items-center hidden space-x-6 md:flex" x-data="navbarLinksState">
              <template x-for="link in navigationLinks">
                <li>
                  <a
                    :href="link.link"
                    @mouseenter="handelMouseEnter($el)"
                    @mouseleave="handelMouseLeave($el)"
                    class="inline-block px-4 py-2 text-gray-500 transition-colors rounded-md  hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 focus-visible:outline-none focus-visible:ring focus-visible:ring-purple-500"
                  >
                    <div class="overflow-hidden">
                      <span x-text="link.label">  </span>
                      <div
                        aria-hidden="true"
                        x-ref="underlineLink"
                        class="underline-link h-0.5 w-full bg-purple-600 translate-x-[102%]"
                      ></div>
                    </div>
                  </a>
                </li>
              </template>
            </ul>

            <!-- Dark mode button -->
            <button @click="toggleTheme" class="text-gray-500 transition-colors hover:text-gray-900 dark:text-gray-400">
              <span class="sr-only">Toggle dark mode</span>
              <svg
                aria-hidden="true"
                class="w-8 h-8"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <!-- Moon path -->
                <path
                  x-show="!isDark"
                  d="M20.742,13.045c-0.677,0.18-1.376,0.271-2.077,0.271c-2.135,0-4.14-0.83-5.646-2.336c-2.008-2.008-2.799-4.967-2.064-7.723 c0.092-0.345-0.007-0.713-0.259-0.965C10.444,2.04,10.077,1.938,9.73,2.034C8.028,2.489,6.476,3.382,5.241,4.616 c-3.898,3.898-3.898,10.243,0,14.143c1.889,1.889,4.401,2.93,7.072,2.93c2.671,0,5.182-1.04,7.07-2.929 c1.236-1.237,2.13-2.791,2.583-4.491c0.092-0.345-0.008-0.713-0.26-0.965C21.454,13.051,21.085,12.951,20.742,13.045z M17.97,17.346c-1.511,1.511-3.52,2.343-5.656,2.343c-2.137,0-4.146-0.833-5.658-2.344c-3.118-3.119-3.118-8.195,0-11.314 c0.602-0.602,1.298-1.102,2.06-1.483c-0.222,2.885,0.814,5.772,2.89,7.848c2.068,2.069,4.927,3.12,7.848,2.891 C19.072,16.046,18.571,16.743,17.97,17.346z"
                ></path>

                <!-- Sun paths -->
                <g x-show="isDark">
                  <path
                    d="M6.993 12c0 2.761 2.246 5.007 5.007 5.007s5.007-2.246 5.007-5.007S14.761 6.993 12 6.993 6.993 9.239 6.993 12zM12 8.993c1.658 0 3.007 1.349 3.007 3.007S13.658 15.007 12 15.007 8.993 13.658 8.993 12 10.342 8.993 12 8.993zM10.998 19H12.998V22H10.998zM10.998 2H12.998V5H10.998zM1.998 11H4.998V13H1.998zM18.998 11H21.998V13H18.998z"
                  ></path>
                  <path transform="rotate(-45.017 5.986 18.01)" d="M4.487 17.01H7.487V19.01H4.487z"></path>
                  <path transform="rotate(-45.001 18.008 5.99)" d="M16.508 4.99H19.509V6.99H16.508z"></path>
                  <path transform="rotate(-134.983 5.988 5.99)" d="M4.487 4.99H7.487V6.99H4.487z"></path>
                  <path
                    transform="rotate(134.999 18.008 18.01)"
                    d="M17.008 16.51H19.008V19.511000000000003H17.008z"
                  ></path>
                </g>
              </svg>
            </button>
          </div>

          <!-- Mobile navigation links -->
          <ul id="mobileMenu" x-data="navbarLinksState" class="h-0 overflow-hidden bg-white dark:bg-gray-900 md:hidden">
            <div class="py-4">
              <template x-for="link in navigationLinks">
                <li>
                  <a :href="link.link" x-text="link.label" class="block px-4 py-2 text-gray-600 dark:text-gray-400"> </a>
                </li>
              </template>
            </div>
          </ul>
        </nav>

        <main>
          <h1 class="sr-only">G App home</h1>

          <section x-data="introSectionState" class="relative min-h-screen intro">
            <div class="relative px-6 pb-24 mx-auto md:pt-24 max-w-7xl">
              <div class="flex flex-col items-center justify-end pt-20 space-y-10 pb-18">
                <h2
                  class="text-4xl font-extrabold leading-snug text-center text-transparent  md:text-6xl lg:text-7xl bg-gradient-to-tr from-pink-500 to-indigo-600 via-blue-600-300 bg-clip-text"
                >
                 {{-- SISTEM INFORMASI MANAJEMEN <br /> --}}
                  {{ Fungsi::app_nama() }}
                </h2>
                {{-- <p class="max-w-xl text-xl font-medium text-center text-gray-600 md:text-2xl">
                    {{ Fungsi::lembaga_alamat() }}
                </p> --}}

                <!-- CTA buttons -->
                <div class="relative z-10 flex items-center justify-center w-full space-x-6">
                  <a href="#"
                    class="relative inline-block overflow-hidden border-2 border-purple-500 rounded-md  group focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800"
                  >
                    <div class="absolute inset-0 flex items-center">
                      <div class="w-1/2 h-full transition-all bg-purple-500 group-hover:-translate-x-full"></div>
                      <div class="w-1/2 h-full transition-all bg-purple-500 group-hover:translate-x-full"></div>
                    </div>
                    <span
                      class="relative inline-block px-4 py-2 text-white transition-colors  group-hover:text-purple-600 dark:group-hover:text-white"
                    >
                      Beranda
                  </span>
                </a>
                  <!-- <button
                    class="relative inline-block overflow-hidden border-2 border-purple-500 rounded-md  group focus:outline-none focus:ring focus:ring-purple-500 focus:ring-offset-1 dark:focus:ring-offset-gray-800"
                  >
                    <div class="absolute inset-0 flex items-center">
                      <div
                        class="w-1/2 h-full transition-all -translate-x-full bg-purple-500 group-hover:translate-x-0"
                      ></div>
                      <div
                        class="w-1/2 h-full transition-all translate-x-full bg-purple-500 group-hover:translate-x-0"
                      ></div>
                    </div>
                    <span
                      class="relative inline-block px-4 py-2 text-gray-900 transition-colors  dark:text-white group-hover:text-white"
                    >
                      About us
                    </span>
                  </button> -->
                </div>
              </div>

              <div
                x-ref="showCase"
                class="relative origin-bottom pointer-events-none select-none  dashboard-showcase md:px-20 md:-mt-20 opacity-30"
              >
                <img x-show="!isDark" class="block w-full" src="/assets/landing/dashboard-showcase.3432ade5.svg" alt="" />
                <img x-show="isDark" class="block w-full" src="/assets/landing/dashboard-showcase-dark.ba0c479a.svg" alt="" />
              </div>
            </div>
          </section>
        </main>

        <footer class="bg-gray-100 dark:bg-gray-900">
          <div
            class="flex flex-col items-center p-6 mx-auto space-y-4 text-gray-500  md:space-y-0 md:flex-row md:justify-between max-w-7xl"
          >
            <a
              href="#"

              class="transition-all hover:-rotate-12 hover:scale-105 hover:text-gray-800 dark:hover:text-gray-100"
            >
              <span class="sr-only">Source code on github</span>

              <svg
                aria-hidden="true"
                class="w-8 h-8"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z"
                ></path>
              </svg>
            </a>
            <p class="flex items-center justify-center space-x-1 text-sm">
              <span>Copyright @ 2021 - </span>
              <!-- <span>
                <span class="sr-only">love</span>
                <svg
                  aria-hidden="true"
                  class="w-5 h-5 text-red-600"
                  xmlns="http://www.w3.org/2000/svg"
                  fill="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    d="M20.205,4.791c-1.137-1.131-2.631-1.754-4.209-1.754c-1.483,0-2.892,0.552-3.996,1.558 c-1.104-1.006-2.512-1.558-3.996-1.558c-1.578,0-3.072,0.623-4.213,1.758c-2.353,2.363-2.352,6.059,0.002,8.412L12,21.414 l8.207-8.207C22.561,10.854,22.562,7.158,20.205,4.791z"
                  ></path>
                </svg>
              </span> -->
              <!-- <span>by</span> -->
              <a href="#" target="_blank" class="text-blue-500 hover:underline">
                SMK DW KROMENGAN
              </a>
            </p>
          </div>
        </footer>
      </div>
    </div>

  </body>
</html>
