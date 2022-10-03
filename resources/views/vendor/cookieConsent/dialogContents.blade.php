<div class="js-cookie-consent cookie-consent">
    <span class="cookie-consent__message">
        {!! trans('cookieConsent::texts.message') !!}
        <!-- <a href="/politica-de-privacidade" target="_blank" title="Acessar a Política de Privacidade do MP Aquicultura" class="btn-privacy-policy">Política de Privacidade do MP Aquicultura</a> -->
    </span>

    <div class="flex">
        <button class="js-cookie-consent-disagree cookie-consent__disagree" id="cookie-disagree">
            {{ trans('cookieConsent::texts.disagree') }}
        </button>
        <button class="js-cookie-consent-agree cookie-consent__agree">
            {{ trans('cookieConsent::texts.agree') }}
        </button>
    </div>
</div>
