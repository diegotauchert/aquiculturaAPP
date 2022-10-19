<div class="js-cookie-consent cookie-consent">
    <div class="flex">
        <span class="cookie-consent__message mr-3">
            {!! trans('cookieConsent::texts.message') !!}
        </span>

        <div class="form-row align-items-center">
            <button class="form-group col-md p-2 js-cookie-consent-disagree cookie-consent__disagree" id="cookie-disagree">
                {{ trans('cookieConsent::texts.disagree') }}
            </button>
            <button class="form-group col-md p-2 js-cookie-consent-agree cookie-consent__agree">
                {{ trans('cookieConsent::texts.agree') }}
            </button>
        </div>
    </div>
</div>
