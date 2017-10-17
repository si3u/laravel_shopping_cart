<footer class="footer footer-style_12">
    <!-- Footer style 12 Top -->
    <div class="footer-top">
        <div class="container">
            <div class="footer-top-inner">
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="title-footer">{{ __('footer.section') }}</h6>
                        <div class="menu-footer footer-left">
                            <ul class="menu">
                                <li class="menu-item"><a href="#">{{ mb_convert_case(__('header.printing'), MB_CASE_TITLE, "UTF-8") }}</a></li>
                                <li class="menu-item"><a href="{{ route('public.price') }}">{{ mb_convert_case(__('header.prices'), MB_CASE_TITLE, "UTF-8") }}</a></li>
                                <li class="menu-item"><a href="{{route('public.news')}}">{{ mb_convert_case(__('header.news'), MB_CASE_TITLE, "UTF-8") }}</a></li>
                                <li class="menu-item"><a href="{{ route('public.contatcs') }}">{{ mb_convert_case(__('header.contacts'), MB_CASE_TITLE, "UTF-8") }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="title-footer">{{ __('footer.help') }}</h6>
                        <div class="menu-footer footer-left">
                            <ul class="menu">
                                <li class="menu-item"><a href="{{ route('public.text_page.payment') }}">{{ __('header.help.payment') }}</a></li>
                                <li class="menu-item"><a href="{{ route('public.text_page.delivery') }}">{{ __('header.help.delivery') }}</a></li>
                                <li class="menu-item"><a href="{{ route('public.text_page.cooperation') }}">{{ __('header.help.cooperation') }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="title-footer">{{ __('footer.contact_info') }}</h6>
                        <div class="menu-footer footer-left">
                            <ul class="menu">
                                <li class="menu-item">
                                    <xmp class="small">{{ $contact->addresses }}</xmp>
                                    <hr>
                                </li>
                                <li class="menu-item"><a href="javascript:void(0);">{{ $contact->tel }}</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="title-footer">{{ __('footer.subscription.name') }}</h6>
                        <div class="newsletter-style5">
                            <div class="newsletter-form">
                                <form method="post" action="#">
                                    <div class="frm-wrap newsletter-content">
                                        <input type="email" name="email" placeholder="{{ __('footer.subscription.input') }}">
                                        <button class="submit-button" type="submit"><i class="fa fa-arrow-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-left">
                <p class="copyright"> © 2017 artvitrina.com.ua</p>
            </div>
            <div class="footer-bottom-right">
                <span class="title-socials">{{ __('footer.copyrighted') }}<a href="http://sfdevelop.com">sfdevelop.com</a></span>

            </div>
        </div>
    </div>

    <a class="backtotop" href="#" style="">
        <span class="icon-top fa fa-arrow-up"></span> Top
    </a>
</footer>
