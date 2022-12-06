<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{route('admin_home')}}">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('admin_home')}}"></a>
        </div>

        <ul class="sidebar-menu">
            <li class="{{Request::is('admin/home') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_home')}}"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>

            <li class="nav-item dropdown {{Request::is('admin/amenity*') ? 'active' : ''}} || {{Request::is('admin/room*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-bed"></i><span>Room Section</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('admin/amenity*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_amenity_view')}}"><i class="fa fa-angle-right"></i>Amenities</a></li>
                    <li class="{{Request::is('admin/room*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_room_view')}}"><i class="fa fa-angle-right"></i>Rooms</a></li>
                </ul>
            </li>

            <li class="{{Request::is('admin/datewise-room*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_datewise_room')}}"><i class="fa fa-calendar"></i> <span>Datewise Rooms</span></a></li>

            <li class="nav-item dropdown {{Request::is('admin/page/about') ? 'active' : ''}} || {{Request::is('admin/page/terms') ? 'active' : ''}} || {{Request::is('admin/page/privacy') ? 'active' : ''}}
            || {{Request::is('admin/page/contact') ? 'active' : ''}} || {{Request::is('admin/page/photo-gallery') ? 'active' : ''}} || {{Request::is('admin/page/video-gallery') ? 'active' : ''}} 
            || {{Request::is('admin/page/faq') ? 'active' : ''}} || {{Request::is('admin/page/blog') ? 'active' : ''}} || {{Request::is('admin/page/room') ? 'active' : ''}} || {{Request::is('admin/page/cart') ? 'active' : ''}} || {{Request::is('admin/page/checkout') ? 'active' : ''}}
            || {{Request::is('admin/page/payment') ? 'active' : ''}} || {{Request::is('admin/page/signup') ? 'active' : ''}} || {{Request::is('admin/page/signin') ? 'active' : ''}} || {{Request::is('admin/page/forget-password*') ? 'active' : ''}} || {{Request::is('admin/page/reset-password*') ? 'active' : ''}}">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-file-text-o"></i><span>Pages</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('admin/page/about*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_about')}}"><i class="fa fa-angle-right"></i> About</a></li>
                    {{-- <li class="{{Request::is('admin/page/terms*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_terms')}}"><i class="fa fa-angle-right"></i>Terms and Conditions</a></li>
                    <li class="{{Request::is('admin/page/privacy*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_privacy')}}"><i class="fa fa-angle-right"></i>Privacy Policy</a></li> --}}
                    <li class="{{Request::is('admin/page/contact*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_contact')}}"><i class="fa fa-angle-right"></i>Contact</a></li>
                    <li class="{{Request::is('admin/page/photo-gallery*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_photo_gallery')}}"><i class="fa fa-angle-right"></i>Photo Gallery</a></li>
                    <li class="{{Request::is('admin/page/video-gallery*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_video_gallery')}}"><i class="fa fa-angle-right"></i>Video Gallery</a></li>
                    <li class="{{Request::is('admin/page/faq*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_faq')}}"><i class="fa fa-angle-right"></i>FAQs</a></li>
                    <li class="{{Request::is('admin/page/blog*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_blog')}}"><i class="fa fa-angle-right"></i>Blog</a></li>
                    <li class="{{Request::is('admin/page/room*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_room')}}"><i class="fa fa-angle-right"></i>Room</a></li>
                    <li class="{{Request::is('admin/page/cart*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_cart')}}"><i class="fa fa-angle-right"></i>Bookings</a></li>
                    <li class="{{Request::is('admin/page/checkout*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_checkout')}}"><i class="fa fa-angle-right"></i>Checkout</a></li>
                    <li class="{{Request::is('admin/page/payment*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_payment')}}"><i class="fa fa-angle-right"></i>Payment</a></li>
                    <li class="{{Request::is('admin/page/signup*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_signup')}}"><i class="fa fa-angle-right"></i>Sign Up</a></li>
                    <li class="{{Request::is('admin/page/signin*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_signin')}}"><i class="fa fa-angle-right"></i>Sign In</a></li>
                    <li class="{{Request::is('admin/page/forget-password*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_forget_password')}}"><i class="fa fa-angle-right"></i>Forget Password</a></li>
                    <li class="{{Request::is('admin/page/reset-password*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_page_reset_password')}}"><i class="fa fa-angle-right"></i>Reset Password</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown {{Request::is('admin/subscriber/show') ? 'active' : ''}} || {{Request::is('admin/subscriber/send-email') ? 'active' : ''}} ">
                <a href="#" class="nav-link has-dropdown"><i class="fa fa-users"></i><span>Subscribers</span></a>
                <ul class="dropdown-menu">
                    <li class="{{Request::is('admin/subscriber/show') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_subscriber_show')}}"><i class="fa fa-angle-right"></i>All Subscribers</a></li>
                    <li class="{{Request::is('admin/subscriber/send-email') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_subscriber_send_email')}}"><i class="fa fa-angle-right"></i>Send Email</a></li>
                </ul>
            </li>

            <li class="{{Request::is('admin/customers') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_customer')}}"><i class="fa fa-user-o"></i> <span>Customers</span></a></li>
            <li class="{{Request::is('admin/order*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_order')}}"><i class="fa fa-book"></i> <span>Bookings</span></a></li>
            <li class="{{Request::is('admin/sales-report') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_sales_report')}}"><i class="fa fa-shopping-cart"></i> <span>Sales Report</span></a></li>
            <li class="{{Request::is('admin/slide*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_slide')}}"><i class="fa fa-sliders"></i> <span>Slide</span></a></li>
            <li class="{{Request::is('admin/feature*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_feature_view')}}"><i class="fa fa-pagelines"></i> <span>Feature</span></a></li>
            <li class="{{Request::is('admin/testimonial*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_testimonial_view')}}"><i class="fa fa-bullhorn"></i> <span>Testimonial</span></a></li>
            <li class="{{Request::is('admin/post*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_post_view')}}"><i class="fa fa-clipboard"></i> <span>Post</span></a></li>
            <li class="{{Request::is('admin/photo*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_photo_view')}}"><i class="fa fa-picture-o"></i> <span>Photo Gallery</span></a></li>
            <li class="{{Request::is('admin/video*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_video_view')}}"><i class="fa fa-video-camera"></i> <span>Video Gallery</span></a></li>
            <li class="{{Request::is('admin/faq*') ? 'active' : ''}}"><a class="nav-link" href="{{route('admin_faq_view')}}"><i class="fa fa-smile-o"></i> <span>FAQs</span></a></li>
        </ul>
    </aside>
</div>