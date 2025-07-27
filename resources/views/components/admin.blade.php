<!--
/*!
 *   AdminLTE With Laravel
 *   Author: Nihir Zala
 *   Website: https://nihirz.netlify.app
 *   License: Open source - MIT <https://opensource.org/licenses/MIT>
 */
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title> @yield('title', 'Admin') | {{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/favicon/site.webmanifest') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Select 2 style -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed {{ Auth::user()->mode }}-mode">

    <div class="wrapper">
        <!-- Navbar -->
        <x-navbar />
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-{{ Auth::user()->mode }}-primary elevation-4">
            <!-- Brand Logo -->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::user()->avatar != null)
                            <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image">
                        @else
                            <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                                alt="User Image">
                        @endif
                    </div>
                    <div class="info">
                        <a href="{{ route('admin.dashboard') }}" class="d-block">{{ config('app.name') }}</a>
                    </div>
                </div>
                <!-- Sidebar Menu -->
                <x-sidebar />
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div> --}}
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                {{ $slot }}
                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <footer class="main-footer">
        <strong>Copyright © {{ date('Y') }} <a href="https://datalogysoftware.com/" target="_blank">Datalogy Software</a>.</strong> All rights reserved.
    </footer>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('admin/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('admin/dist/js/pages/dashboard.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- tinyMCE  JS  -->
    <script src="https://cdn.tiny.cloud/1/rh0a8dvy4z76ykhzdo0v5ko2jjyzek4xkcctjpb9qcjhfrph/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Date Range Picker JS  -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer="defer"></script>
    <!-- jQuery Validate -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

     <!-- Select 2 script -->   
     <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Toast cdn -->
    <script src="{{ asset('admin/dist/js/toastr.min.js') }}"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Toastr alerts
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        }
    </script>
    <x-alert />
    @yield('js')
    <script>
        $(document).ready(function(){
                    tinymce.init({
                        selector: '#title',
                        plugins: 'emoticons',
                        toolbar: 'emoticons',
                        menubar: false,
                        statusbar: false,
                        branding: false,
                        elementpath: false,
                        content_css: [
                                'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/skins/content/default/content.min.css',
                            //    'https://cdn.tiny.cloud/1/21xf9zvx257tniynaat6gpgdhfyr85skudvrltea03i3mlbt/tinymce/6/content.min.css',
                                'https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/assets/css/emojione.min.css',
                                '{{asset("admin/dist/css/cutom_tinymce.css")}}'
                            ],
                        height: 125
                    });

                    var imageCount = 0;
                    tinymce.init({
                        selector: '#description',
                        plugins: 'image emoticons',
                        toolbar: 'image emoticons',
                        menubar: false,
                        statusbar: false,
                        branding: false,
                        elementpath: false,
                        file_picker_callback: function (callback, value, meta) {
                                if (meta.filetype === 'image') {
                                    const input = document.createElement('input');
                                    input.setAttribute('type', 'file');
                                    input.setAttribute('accept', 'image/*');
                                    input.onchange = function () {
                                        const file = input.files[0];
                                        const formData = new FormData();
                                        formData.append('file', file);
                                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                        console.log(pushStoreImageRoute);
                                        
                                        $.ajax({
                                            url: pushStoreImageRoute,
                                            type: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': csrfToken // Include CSRF token here
                                            },
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function (response) {
                                                callback(response.location, { alt: file.name });
                                            },
                                            error: function (xhr, status, error) {
                                                console.error('Error:', error);
                                            }
                                        });
                                    };
                                    input.click();
                                }
                            }, 
                            setup: function (editor) {
                                var imageCount = 0;
                                // Limit image uploads to only one image
                                function initMutationObserver() {
                                var mutationObserver = new MutationObserver(function (mutations) {
                                    mutations.forEach(function (mutation) {
                                    if (mutation.removedNodes.length) {
                                        Array.from(mutation.removedNodes).forEach(function (node) {
                                        if (node.nodeName === 'IMG') {
                                            if (editor.dom.getAttrib(node, 'data-counted')) {
                                            imageCount--;
                                            }
                                        }
                                        });
                                    }
                                    });
                                });
                                
                                // Observe changes in the editor's body
                                mutationObserver.observe(editor.getBody(), {
                                    childList: true,
                                    subtree: true
                                });
                                }
                                editor.on('NodeChange', function (e) {
                                if (e.element.nodeName === 'IMG' &&  !editor.dom.getAttrib(e.element, 'data-counted')) {
                                    imageCount++;
                                    editor.dom.setAttrib(e.element, 'data-counted', 'true');
                                    if (imageCount > 1) {
                                    alert('Only one image is allowed');
                                    editor.undoManager.transact(function () {
                                        editor.dom.remove(e.element);
                                    });
                                    imageCount--;
                                    }
                                }
                                });
                                editor.on('init', initMutationObserver);

                                // Clean up the observer on editor removal
                                editor.on('Remove', function () {
                                if (mutationObserver) {
                                    mutationObserver.disconnect();
                                }
                                });
                                
                            },
                            init_instance_callback: function (editor) {
                                    imageCount = 0;
                                    $('#pushNotificationForm').submit(function (e) {
                                        var content = editor.getContent();
                                        imageCount = $(content).find('img').length;
                                        // var textOnly = content.replace(/<img[^>]*>/g, '').replace(/<[^>]+>/g, ''); // remove image tags and other HTML tags
                                        // textOnly = $.trim(textOnly); // remove whitespace

                                        if (imageCount > 1) {
                                            alert('Only one image is allowed');
                                            e.preventDefault();
                                        } 
                                        // else if (imageCount === 1 && textOnly === '') {
                                        //     alert('Please enter a description text or emojis');
                                        //     e.preventDefault();
                                        // }
                                });
                                },
                            extended_valid_elements: 'img[!src|alt=|title|width|height|style],span[class|data-emoticon]',
                            valid_children: '+body[span|img]',
                            content_css: [
                                'https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.3/skins/content/default/content.min.css',
                            //    'https://cdn.tiny.cloud/1/21xf9zvx257tniynaat6gpgdhfyr85skudvrltea03i3mlbt/tinymce/6/content.min.css',
                                'https://cdnjs.cloudflare.com/ajax/libs/emojione/2.2.7/assets/css/emojione.min.css',
                                '{{asset("admin/dist/css/cutom_tinymce.css")}}'
                            ],
                            height: 200
                    });
                if ($('#settingsMenu .nav-link.active').length > 0) {
                            $('#settingsMenu').collapse('show');
                }

                $('#settingsToggle').click(function(e){
                e.preventDefault();
                $('#settingsMenu').collapse('toggle');
                });

            // delivery toggle
            if ($('#deliveryMenu .nav-link.active').length > 0) {
                            $('#deliveryMenu').collapse('show');
                }
                $('#deliveryToggle').click(function(e){
                e.preventDefault();
                $('#deliveryMenu').collapse('toggle');
                });
        });
    </script>
</body>

</html>
