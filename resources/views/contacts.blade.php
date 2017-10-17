@extends('layouts.main')

@section('title', 'ArtVitrina | News')

@section('content')
    @include('includes.header')
    <div class="main-content">
            <div class="site-content-inner">
                <div class="container">
                    <div class="row">
                        <div id="primary" class="content-area col-xs-12 col-sm-12 col-md-12" style="padding:150px 0 0;">
                            <div id="main" class="site-main">
                                <div class="contact-wrap">
                                    <input type="hidden" id="address" value="@isset($contact->addresses){{strip_tags($contact->addresses)}}@endisset">
                                    <div style="width: 100%; height: 400px;" id="map_canvas"></div>

                                    <div class="xshop-contact-form">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="contact-info">
                                                    <h5 class="title-contact-info">{{ __('footer.contact_info') }}</h5>
                                                    <ul class="list-contact-info equal-container">
                                                        <li class="item-contact-info">
                                                            <div class="contact-info-inner equal-elem img-width" style="height: 156px;">
                                                                <span class="icon-info">
                                                                    <img src="{{asset('assets/images/icon-map.png')}}" alt="img">
                                                                </span>
                                                                <div class="contact-info-content">
                                                                    <h6 class="title-info">{{ __('contacts.address') }}</h6>
                                                                    <div class="desc-info">
                                                                        {{ $contact->addresses }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="item-contact-info">
                                                            <div class="contact-info-inner equal-elem img-width" style="height: 156px;">
                                                                <span class="icon-info">
                                                                    <img src="{{asset('assets/images/icon-phone.png')}}" alt="img">
                                                                </span>
                                                                <div class="contact-info-content">
                                                                    <h6 class="title-info">{{ __('contacts.tel') }}</h6>
                                                                    <div class="desc-info">{{ $contact->tel }}</div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="item-contact-info">
                                                            <div class="contact-info-inner equal-elem img-width" style="height: 156px;">
                                                                <span class="icon-info">
                                                                    <img src="{{asset('assets/images/icon-mail.png')}}" alt="img">
                                                                </span>
                                                                <div class="contact-info-content">
                                                                    <h6 class="title-info">{{ __('contacts.email') }}</h6>
                                                                    <div class="desc-info">
                                                                        <a href="mailto:{{ $contact->email }}">
                                                                            {{ $contact->email }}
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="item-contact-info">
                                                            <div class="contact-info-inner equal-elem img-width" style="height: 156px;">
                                                                <span class="icon-info">
                                                                    <img src="{{asset('assets/images/icon-clock.png')}}" alt="img">
                                                                </span>
                                                                <div class="-info-content">
                                                                    <h6 class="title-info">{{ __('contacts.working_days') }}</h6>
                                                                    <div class="desc-info">
                                                                        {{ $contact->working_days }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h5 class="title-contact-info">{{ __('contacts.support.title') }}</h5>
                                                <div class="contact-form ">
                                                    @include('includes.contacts.form')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('my_scripts')
    {!! script_ts('/assets/js/project/contacts.js') !!}
    <script type="text/javascript">
    function geocodeAddress() {
        var resultsMap = new google.maps.Map(document.getElementById('map_canvas'), {
          zoom: 17,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();

        var address = document.getElementById('address').value;
        
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7R0RER7gnRGPV95pkyA7kbieNaY7JxaE&callback=geocodeAddress"></script>
@endsection
