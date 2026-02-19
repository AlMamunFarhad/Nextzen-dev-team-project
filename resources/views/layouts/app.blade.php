<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/boxicons.css') }}" />

     {{-- ✅ Multi Language Support --}}
    <script>
      function googleTranslateElementInit() {
        new google.translate.TranslateElement({
          pageLanguage: 'en',
          autoDisplay: false,
        }, 'google_translate_element');
      }
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

     <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">

        {{-- ✅ Multi Language Support --}}
        <div id="google_translate_element" style="display:none"></div>

        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('admin/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>


    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Main JS -->
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('admin/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<<<<<<< HEAD





     <!-- Toastr JS -->

    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "6000"
        }

        @if ($errors->any())
            toastr.error("{{ $errors->first() }}");
        @endif

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif

    </script>


    {{-- Dynamic Delete Confirmation with SweetAlert --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".delete-form").forEach(form => {
                form.addEventListener("submit", function (e) {
                    e.preventDefault(); // stop form submission

                    let message = form.getAttribute("data-message") || "Are you sure you want to delete this item?";

                    Swal.fire({
                        title: "Confirm Delete",
                        text: message,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // finally submit if confirmed
                        }
                    });
                });
            });
        });
    </script>

=======
    @stack('scripts')
    <script>
        function confirmDelete(url, rowId = null, message = "Are you sure?", callback = null) {
            Swal.fire({
                title: message,
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': form._token.value,
                                'Accept': 'application/json'
                            }
                        })
                        .then(async res => {
                            const data = await res.json().catch(() => ({}));
                            if (!res.ok) throw data;
                            return data;
                        })
                        .then(data => {
                            showToast(data.message || 'Deleted', 'danger');

                            if (rowId) document.getElementById(rowId)?.remove();
                            if (callback) callback(data);
                        })
                        .catch(() => showToast('Delete failed!', 'danger'));
                }
            });
        }
    </script>
>>>>>>> main


   {{-- ✅ Multi Language Support --}}

    <script>
        function translatePage(langCode) {
            if (langCode === 'en') {
                // English = reset/restore original
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + location.hostname;
                location.reload();
                return;
            }

            document.cookie = `googtrans=/en/${langCode};path=/`;
            document.cookie = `googtrans=/en/${langCode};path=/;domain=.${location.hostname}`;

            const tryTranslate = setInterval(() => {
                const gtSelect = document.querySelector('.goog-te-combo');
                if (gtSelect) {
                    gtSelect.value = langCode;
                    gtSelect.dispatchEvent(new Event('change'));
                    clearInterval(tryTranslate);
                }
            }, 100);
        }
    </script>


</body>

</html>
