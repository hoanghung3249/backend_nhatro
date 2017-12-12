<!DOCTYPE html>
<html>
<head>
    <base src="{{ URL::asset('/') }}" />
    <meta charset="UTF-8">
    <title>
        @section('title')
            @setting('core::site-name') | Admin
        @show
    </title>
    <meta id="token" name="token" value="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">
    @foreach($cssFiles as $css)
        <link media="all" type="text/css" rel="stylesheet" href="{{ URL::asset($css) }}">
    @endforeach
    {!! Theme::script('vendor/jquery/jquery.min.js') !!}
    @include('partials.asgard-globals')
    @section('styles')
    @show
    @stack('css-stack')

    <script>
        $.ajaxSetup({
            headers: { 'Authorization': 'Bearer {{ $currentUser->getFirstApiKey() }}' }
        });
        var AuthorizationHeaderValue = 'Bearer {{ $currentUser->getFirstApiKey() }}';
    </script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="{{ config('asgard.core.core.skin', 'skin-blue') }} sidebar-mini" style="padding-bottom: 0 !important;">
<div class="wrapper">
    <header class="main-header">
        <a href="{{ URL::route('dashboard.index') }}" class="logo">
            <span class="logo-mini">
                @setting('core::site-name-mini')
            </span>
            <span class="logo-lg">
                @setting('core::site-name')
            </span>
        </a>
        @include('partials.top-nav')
    </header>
    @include('partials.sidebar-nav')

    <aside class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            @yield('content-header')
        </section>

        <!-- Main content -->
        <section class="content">
            @include('partials.notifications')
            @yield('content')
        </section><!-- /.content -->
    </aside><!-- /.right-side -->
    @include('partials.footer')
    @include('partials.right-sidebar')


<div id="modal-detail-customer" class="modal fade modal-default in" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="delete-confirmation-title">Thông tin chi tiết của khách hàng</h4>
        </div>
        <div class="modal-body">
            <div class="default-message">
                                </div>
            <div class="custom-message"></div>
        </div>
      <div class="modal-footer">

        <button type="button" class="btn btn-default btn-flat btn-outline-secondary" data-dismiss="modal">Huỷ bỏ</button>
      </div>
    </div>

  </div>
</div>



</div><!-- ./wrapper -->

@foreach($jsFiles as $js)
    <script src="{{ URL::asset($js) }}" type="text/javascript"></script>
@endforeach
<script type="text/javascript" src ="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
<?php if (is_module_enabled('Notification')): ?>
    <script src="https://js.pusher.com/3.0/pusher.min.js"></script>
    <script src="{{ Module::asset('notification:js/pusherNotifications.js') }}"></script>
    <script>
        $(".notifications-list").pusherNotifications({
            pusherKey: '{{ env('PUSHER_KEY') }}',
            loggedInUserId: {{ $currentUser->id }}
        });
    </script>
<?php endif; ?>

<?php if (config('asgard.core.core.ckeditor-config-file-path') !== ''): ?>
    <script>
        $('.ckeditor').each(function() {
            CKEDITOR.replace($(this).attr('name'), {
                customConfig: '{{ config('asgard.core.core.ckeditor-config-file-path') }}'
            });
        });
    </script>
<?php endif; ?>


@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{{-- {!! JsValidator::formRequest('Modules\User\Http\Requests\CreateUserRequest') !!} --}}
@show
@stack('js-stack')
</body>
</html>
