$(function () {
    responsivo();

    function responsivo() {
        var tamanhoTela = $('<div></div>').addClass('p-2').addClass('position-fixed').addClass('d-flex').css({zIndex: 100000}).append($('<div></div>').addClass('alert').addClass('alert-primary').addClass('shadow').addClass('mx-auto').addClass('text-center').addClass('font-weight-bold'));
        var closeTela = '&nbsp;<button type="button" class="close" data-dismiss="alert" aria-label="Fechar"><span class="fa fa-times"></span></button>';

        tela();

        $(window).resize(function () {
            telaTamanho();
        });

        function tela() {
            $('body').prepend(tamanhoTela);
            telaTamanho();
        }

        function telaTamanho() {
            if ($('body').width() < 576) {
                $('.alert', tamanhoTela).html('XS - Extra small (col)');
            } else {
                if ($('body').width() > 575 && $('body').width() < 768) {
                    $('.alert', tamanhoTela).html('SM - Small (col-sm)');
                } else {
                    if ($('body').width() > 767 && $('body').width() < 992) {
                        $('.alert', tamanhoTela).html('MD - Medium (col-md)');
                    } else {
                        if ($('body').width() > 991 && $('body').width() < 1200) {
                            $('.alert', tamanhoTela).html('LG - Large (col-lg)');
                        } else {
                            $('.alert', tamanhoTela).html('XL - Extra large (col-xl)');
                        }
                    }
                }
            }

            $('.alert', tamanhoTela).append(closeTela);
        }
    }
});
