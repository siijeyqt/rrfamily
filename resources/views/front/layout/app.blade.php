<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
        <meta name="description" content="">
        <title>RR Family Spring Resort</title>        
		
        <link rel="icon" type="image/png" href="{{asset('uploads/'.$global_setting_data->favicon)}}">

        @include('front.layout.styles')
        @include('front.layout.scripts')

        <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500&display=swap" rel="stylesheet">
        
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{$global_setting_data->analytic_id}}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', {{$global_setting_data->analytic_id}});
        </script>

    </head>
    <body>
        
        <div class="top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 left-side">
                        <ul>
                            @if ($global_setting_data->top_bar_phone != '')
                                <li class="phone-text">+{{$global_setting_data->top_bar_phone}}</li>
                            @endif
                            @if($global_setting_data->top_bar_email != '')
                                <li class="email-text">{{$global_setting_data->top_bar_email}}</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6 right-side">
                        <ul class="right">

                            @if($global_page_data->cart_status == 1)
                            <li class="menu"><a href="{{route('cart')}}">{{$global_page_data->cart_heading}}
                                @if(session()->has('cart_room_id'))<sup>{{count(session()->get('cart_room_id'))}}</sup>@endif
                            </a></li>
                            @endif

                            @if($global_page_data->checkout_status == 1)
                            <li class="menu"><a href="{{route('checkout')}}">{{$global_page_data->checkout_heading}}</a></li>
                            @endif

                            @if(!Auth::guard('customer')->check())
                                @if($global_page_data->signup_status == 1)
                                <li class="menu"><a href="{{route('customer_signup')}}">{{$global_page_data->signup_heading}}</a></li>
                                @endif

                                @if($global_page_data->signin_status == 1)
                                <li class="menu"><a href="{{route('customer_login')}}">{{$global_page_data->signin_heading}}</a></li>
                                @endif
                            @else
                                <li class="menu"><a href="{{route('customer_home')}}">Dashboard</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="navbar-area" id="stickymenu">

            <!-- Menu For Mobile Device -->
            <div class="mobile-nav">
                <a href="{{route('home')}}" class="logo">
                    <img src="{{asset('uploads/'.$global_setting_data->logo)}}" alt="">
                </a>
            </div>
        
            <!-- Menu For Desktop Device -->
            <div class="main-nav">
                <div class="container">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <a class="navbar-brand" href="{{route('home')}}">
                            <img src="{{asset('uploads/'.$global_setting_data->logo)}}" alt="">
                        </a>
                        <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">        
                                <li class="nav-item">
                                    <a href="{{route('home')}}" class="nav-link">Home</a>
                                </li>

                                @if($global_page_data->about_status == 1)
                                <li class="nav-item">
                                    <a href="{{route('about')}}" class="nav-link">{{$global_page_data->about_heading}}</a>
                                </li>
                                @endif
                                <li class="nav-item">
                                    <a href="javascript:void;" class="nav-link dropdown-toggle">Room & Suite</a>
                                    <ul class="dropdown-menu">
                                        @foreach($global_room_data as $item)
                                        <li class="nav-item">
                                            <a href="{{route('room_detail', $item->id)}}" class="nav-link">{{$item->name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </li>

                                @if($global_page_data->video_gallery_status == 1 || $global_page_data->photo_gallery_status == 1)
                                <li class="nav-item">
                                    <a href="javascript:void;" class="nav-link dropdown-toggle">Gallery</a>
                                    <ul class="dropdown-menu">
                                        @if($global_page_data->photo_gallery_status == 1)
                                        <li class="nav-item">
                                            <a href="{{route('photo_gallery')}}" class="nav-link">{{$global_page_data->photo_gallery_heading}}</a>
                                        </li>
                                        @endif
                                        @if($global_page_data->video_gallery_status == 1)
                                        <li class="nav-item">
                                            <a href="{{route('video_gallery')}}" class="nav-link">{{$global_page_data->video_gallery_heading}}</a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                                @endif

                                @if($global_page_data->blog_status == 1)
                                <li class="nav-item">
                                    <a href="{{route('blog')}}" class="nav-link">Blog</a>
                                </li>
                                @endif

                                @if($global_page_data->contact_status == 1)
                                <li class="nav-item">
                                    <a href="{{route('contact')}}" class="nav-link">{{$global_page_data->contact_heading}}</a>
                                </li>
                                @endif

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        @yield('main_content')

        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="item">
                            <h2 class="heading">Site Links</h2>
                            <ul class="useful-links">

                                @if($global_page_data->photo_gallery_status == 1)
                                <li><a href="{{route('photo_gallery')}}">{{$global_page_data->photo_gallery_heading}}</a></li>
                                @endif

                                @if($global_page_data->video_gallery_status == 1)
                                <li><a href="{{route('video_gallery')}}">{{$global_page_data->video_gallery_heading}}</a></li>
                                @endif

                                @if($global_page_data->blog_status == 1)
                                <li><a href="{{route('blog')}}">{{$global_page_data->blog_heading}}</a></li>
                                @endif

                                @if($global_page_data->contact_status == 1)
                                <li><a href="{{route('contact')}}">{{$global_page_data->contact_heading}}</a></li>
                                @endif

                            </ul>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="item">
                            <h2 class="heading">Useful Links</h2>
                            <ul class="useful-links">
                                <li><a href="{{route('home')}}">Home</a></li>

                                @if($global_page_data->terms_status == 1)
                                <li><a href="{{route('terms')}}">{{$global_page_data->terms_heading}}</a></li>
                                @endif

                                @if($global_page_data->privacy_status == 1)
                                <li><a href="{{route('privacy')}}">{{$global_page_data->privacy_heading}}</a></li>
                                @endif

                                @if($global_page_data->faq_status == 1)
                                <li><a href="{{route('faq')}}">{{$global_page_data->faq_heading}}</a></li>
                                @endif

                            </ul>
                        </div>
                    </div> --}}
                    <div class="col-md-4">
                        <div class="item">
                            <h2 class="heading">Contact</h2>
                            <div class="list-item">
                                <div class="left">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="right">
                                    {!! $global_setting_data->footer_address !!}
                                </div>
                            </div>
                            <div class="list-item">
                                <div class="left">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <div class="right">
                                    {{$global_setting_data->footer_email}}
                                </div>
                            </div>
                            <div class="list-item">
                                <div class="left">
                                    <i class="fa fa-volume-control-phone"></i>
                                </div>
                                <div class="right">
                                    +{{$global_setting_data->footer_phone}}
                                </div>
                            </div>
                            <ul class="social">
                                @if($global_setting_data->facebook != '')
                                    <li><a href="{{$global_setting_data->facebook}}"><i class="fa fa-facebook-f"></i></a></li>
                                @endif
                                @if($global_setting_data->twitter != '')
                                    <li><a href="{{$global_setting_data->twitter}}"><i class="fa fa-twitter"></i></a></li>
                                @endif
                                @if($global_setting_data->instagram != '')
                                    <li><a href="{{$global_setting_data->instagram}}"><i class="fa fa-instagram"></i></a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item">
                            <h2 class="heading">Newsletter</h2>
                            <p>
                                In order to get the latest news and other great items, please subscribe us here: 
                            </p>
                            <form action="{{route('subscriber_send_email')}}" method="post" class="form_subscribe_ajax" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="email" class="form-control">
                                    <span class="text-danger error-text email_error"></span>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" value="Subscribe Now">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="copyright">
            <i class="fa fa-copyright"></i> 
            {{$global_setting_data->copyright}}
        </div>
     
        <div class="scroll-top">
            <i class="fa fa-angle-up"></i>
        </div>
		
        @include('front.layout.scripts_footer') 

        @if(session()->get('error'))
            <script>
                iziToast.error({
                title: '',
                position: 'topRight',
                message: '{{session()->get('error')}}',
                });
            </script>
        @endif
        
        @if(session()->get('success'))
            <script>
                iziToast.success({
                title: '',
                position: 'topRight',
                message: '{{session()->get('success')}}',
                });
            </script>
        @endif
        <script>
            (function($){
                $(".form_subscribe_ajax").on('submit', function(e){
                    e.preventDefault();
                    $('#loader').show();
                    var form = this;
                    $.ajax({
                        url:$(form).attr('action'),
                        method:$(form).attr('method'),
                        data:new FormData(form),
                        processData:false,
                        dataType:'json',
                        contentType:false,
                        beforeSend:function(){
                            $(form).find('span.error-text').text('');
                        },
                        success:function(data)
                        {
                            $('#loader').hide();
                            if(data.code == 0)
                            {
                                $.each(data.error_message, function(prefix, val) {
                                    $(form).find('span.'+prefix+'_error').text(val[0]);
                                });
                            }
                            else if(data.code == 1)
                            {
                                $(form)[0].reset();
                                iziToast.success({
                                    title: '',
                                    position: 'topRight',
                                    message: data.success_message,
                                });
                            }
                        }
                    });
                });
            })(jQuery);
        </script>
        <div id="loader"></div>
   </body>
</html>