<form id="form_support" class="form-contact" action="{{ route('public.support.send_mail') }}" method="post" onclick="return false;">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <p>
                <input type="text" placeholder="{{ __('contacts.support.input_name') }}" class="input-control first-name" value="" name="name">
            </p>
        </div>
        <div class="col-sm-6 col-xs-12">
            <p>
                <input type="text" placeholder="{{ __('contacts.support.input_subject') }}" class="input-control second-name" value="" name="title">
            </p>
        </div>
        <div class="col-sm-12 col-md-12" style="border-top-style: ridge;border-top-width: 1px;">
            <p>
                <input type="text" placeholder="{{ __('contacts.email') }}" class="input-control" name="email">
            </p>
        </div>
        <div class="col-sm-12 col-md-12">
            <p>
                <textarea placeholder="{{ __('contacts.support.input_message') }}" aria-invalid="false" class="textarea-control" rows="5" cols="40" name="text_message"></textarea>
            </p>
        </div>
        @include('includes.alerts.ajax')
        <div class="col-sm-12 col-md-12">
            <p>
                <input type="button" id="btn_send_message" class="button-duck" value="{{ __('contacts.support.button') }}">
            </p>
        </div>
    </div>
</form>
