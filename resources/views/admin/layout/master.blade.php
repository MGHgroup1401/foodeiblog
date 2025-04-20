<!DOCTYPE html>
<html lang="fa" dir='rtl'> 

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>@yield('title','foodeiblog Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
   
    @include('admin.layout.header-links')
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        @include('admin.layout.header')

        @include('admin.layout.sidebar')

        @yield('content')
        @include('admin.layout.footer')
    </div>
    @include('admin.layout.footer-scripts')
   
  
 
</body>

</html>