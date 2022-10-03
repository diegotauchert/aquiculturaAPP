require("./bootstrap");
// require('./responsivo');
const tinymce = require("tinymce/tinymce");
require("./tinymce");

require("./lightgallery");

const ClipboardJS = require("clipboard");
const bootbox = require("bootbox");
const bootstrapSelect = require("bootstrap-select");
const masks = require("jquery-mask-plugin");
const accents = require("remove-accents");
const urlSlugMatch = require("url-slug-match");
require("jquery-file-upload");

import "jquery-ui/ui/widgets/datepicker.js";
import "jquery-ui/ui/widgets/sortable.js";
import "jquery-ui/ui/i18n/datepicker-pt-BR.js";

import i18next from "i18next";
import i18nextLanguageBundle from "@kirschbaum-development/laravel-translations-loader?namespace=translation!@kirschbaum-development/laravel-translations-loader";

$(function() {
    bootbox.setDefaults({
        locale: "br"
    });

    i18next.init({
        lng: "pt-br",
        debug: false,
        lowerCaseLng: true,
        resources: i18nextLanguageBundle
    });

    new ClipboardJS(".copy");

    init($("body"));
});

function init(p) {
    $(".popup", p).modal("show");

    ajustaNavbar(p);
    extras(p);
    clones(p);
    selects(p);
    extraMasks(p);
    galeria(p);
    uploads(p);
    checkAdvogadoServico(p);
    actionMenuClientes(p);
}

function checkAdvogadoServico(p) {
    $(".check-advogado-servico").change(function() {
        if ($(this).prop("checked")) {
            $(this)
                .closest(".advogado-servico")
                .find(".text")
                .removeAttr("disabled");
            $(this)
                .closest(".advogado-servico")
                .find(".your-price")
                .removeAttr("readonly");
            $(this)
                .closest(".advogado-servico")
                .find(".service")
                .addClass("alert-success");
        } else {
            $(this)
                .closest(".advogado-servico")
                .find(".text")
                .attr("disabled", "disabled");
            $(this)
                .closest(".advogado-servico")
                .find(".your-price")
                .attr("readonly", "readonly");
            $(this)
                .closest(".advogado-servico")
                .find(".service")
                .removeClass("alert-success");
        }
    });
}

function ajustaNavbar(p) {
    $(window).scroll(function() {
        if ($(window).scrollTop() > 0) {
            if (!$(".fixed-top").hasClass("active")) {
                $(".fixed-top").addClass("active");
            }
        } else {
            if ($(".fixed-top").hasClass("active")) {
                $(".fixed-top").removeClass("active");
            }
        }
    });

    $(".menu li").hover(
        function() {
            if (!$(this).hasClass("active")) {
                $(this)
                    .stop(false, true)
                    .addClass("hover", 500);
            }

            $(">ul", this)
                .stop(false, true)
                .addClass("open");
        },
        function() {
            if (!$(this).hasClass("active")) {
                $(this)
                    .stop(false, true)
                    .removeClass("hover", 500);
            }

            $(">ul", this)
                .stop(false, true)
                .removeClass("open");
        }
    );

    $('[data-toggle="offcanvas"]', p).click(function() {
        $(".offcanvas-collapse", p).toggleClass("open");
    });

    $("#dropdown_busca").click(function(e) {
        setTimeout(function() {
            $("#p").focus();
        }, 100);
    });

    $("#banners .carousel-item.active .carousel-caption")
        .css({
            left: -200,
            opacity: 0
        })
        .animate(
            {
                left: 0,
                opacity: 1
            },
            500
        );

    $("#banners").on("slid.bs.carousel", function(a) {
        $("#banners .carousel-item.active .carousel-caption").animate(
            {
                left: 0,
                opacity: 1
            },
            500
        );
    });

    $("#banners").on("slide.bs.carousel", function(a) {
        $("#banners .carousel-item:not(.active) .carousel-caption").animate(
            {
                left: -200,
                opacity: 0
            },
            250
        );
    });
}

function extras(b) {
    $('[data-toggle="tooltip"], .o-tooltip', b).tooltip({
        html: true,
        container: "body"
    });

    $(".confirm", b).click(function(e) {
        e.preventDefault();

        var t = $(this);
        var c = bootbox.confirm({
            message: "<b>" + t.attr("data-title") + "</b>",
            centerVertical: true,
            buttons: {
                cancel: {
                    label:
                        '<span class="fas fa-times"></span> ' +
                        i18next.t("gestor.no")
                },
                confirm: {
                    label:
                        '<span class="fas fa-check"></span> ' +
                        i18next.t("gestor.yes")
                }
            },
            callback: function(response) {
                if (response) {
                    var dip = bootbox.dialog({
                        message:
                            '<div class="text-center"><span class="spinner-border spinner-border-lg"></span><br>' +
                            i18next.t("gestor.carregando") +
                            "</div>",
                        centerVertical: true,
                        onEscape: true
                    });

                    setTimeout(function() {
                        if (t.attr("type") === "submit") {
                            $(t)
                                .parentsUntil(t, "form")
                                .submit();
                        } else {
                            document.location.href = t.attr("href");
                        }
                    }, 250);
                }
            }
        });
    });

    $(".preview", b).click(function() {
        var t = $(this);
        var a = t.attr("href");
        var tipo = t.data("preview-t");
        var size = t.data("preview-size");

        var w = window;
        var x = w.innerWidth;
        var y = w.innerHeight;

        var out;

        if (tipo === "img") {
            out = '<img src="' + a + '" width="100%">';
        } else {
            out =
                '<iframe src="' +
                a +
                '" frameborder="0" width="100%" height="' +
                (size === "small"
                    ? y * 0.4 + "px"
                    : size === "large"
                    ? y * 0.7 + "px"
                    : y * 0.6 + "px") +
                '"></iframe>';
        }

        if (out) {
            bootbox.dialog({
                message: out,
                buttons: {
                    cancel: {
                        label: '<span class="fas fa-times"></span> Fechar',
                        className: "btn-outline-primary"
                    }
                },
                size:
                    size === "small"
                        ? "small"
                        : size === "large"
                        ? "large"
                        : null
            });
        }

        return false;
    });

    $(".mostrar-senha", b).click(function() {
        var t = $(this);
        var c = $(".form-control", t.parentsUntil(t, ".input-group"));
        var ty = c.attr("type");

        c.attr("type", ty === "text" ? "password" : "text");

        t.attr(
            "data-original-title",
            ty === "text" ? i18next.t("gestor.show") : i18next.t("gestor.hide")
        )
            .find(".fas")
            .addClass(ty === "text" ? "fa-eye" : "fa-eye-slash")
            .removeClass(ty === "text" ? "fa-eye-slash" : "fa-eye");

        $("#" + t.attr("aria-describedby") + " .tooltip-inner").html(
            ty === "text" ? i18next.t("gestor.show") : i18next.t("gestor.hide")
        );

        t.tooltip("update");

        return false;
    });

    $(
        "select.selectpicker-custom:not(.has-selectpicker-custom)",
        b
    ).selectpicker({
        actionsBox: true,
        countSelectedText: function(a, b) {
            return i18next.t("gestor.selecionados", {
                first: a,
                last: b
            });
        },
        virtualScroll: 200,
        dropupAuto: true,
        iconBase: "fas",
        liveSearch: true,
        liveSearchNormalize: true,
        liveSearchPlaceholder: i18next.t("gestor.find"),
        selectedTextFormat: "count > 2",
        selectOnTab: true,
        dropdownAlignRight: true,
        tickIcon: "fa-check",
        deselectAllText: "Desmarcar todos",
        selectAllText: "Selecionar todos",
        style: "btn-outline-tertiary text-dark text-reset",
        showTick: true,
        showSubtext: true
    });

    $("select.select-toogle", b)
        .change(function() {
            var t = $(this);
            var n = t.attr("name");
            var v = t.val();

            $("." + n, b).fadeOut(250, function() {
                $("." + n + "-" + v, b).fadeIn(250);
            });
        })
        .trigger("change");

    $(".carousel-multi .carousel-item", b).each(function() {
        var next = $(this).next();
        if (!next.length) {
            next = $(this).siblings(":first");
        }
        next.children(":first-child")
            .clone()
            .appendTo($(this));

        for (var i = 0; i < 2; i++) {
            next = next.next();
            if (!next.length) {
                next = $(this).siblings(":first");
            }

            next.children(":first-child")
                .clone()
                .appendTo($(this));
        }
    });
}

function clones(b) {
    $(".add-clone", b).click(function() {
        var t = $(this);
        var i = t.parentsUntil(t, ".item");
        var p = t.parentsUntil(t, ".clones");
        var tot = $(".item", p).length;
        var c = i.clone();

        p.append(c.attr("display", "none")).fadeIn(250);

        resetElements(c, tot);

        return false;
    });

    $(".duplicate-clone", b).click(function() {
        var t = $(this);
        var i = t.parentsUntil(t, ".item");
        var p = t.parentsUntil(t, ".clones");
        var tot = $(".item", p).length;
        var c = i.clone();

        p.append(c.attr("display", "none")).fadeIn(250);

        resetElements(c, tot, false);

        return false;
    });

    $(".remove-clone", b).click(function() {
        var t = $(this);
        var i = t.parentsUntil(t, ".item");
        var p = t.parentsUntil(t, ".clones");
        var tot = $(".item", p).length;

        if (tot < 2) {
            $(".add-clone", i).trigger("click");
        }

        i.fadeOut(250, function() {
            $(this).remove();
        });

        return false;
    });
}

function resetElements(c, tot, full = true) {
    $("input, select", c).each(function() {
        var t = $(this);
        var id = t.data("clone-id") + "_";

        if (id) {
            t.attr("id", id + (tot + 1));

            if (t.data("clone-ref")) {
                t.attr("data-ref", t.data("clone-ref") + "_" + (tot + 1));
            }
        }

        if (t.hasClass("radio")) {
            t.attr("name", t.data("clone-id") + "[" + (c.index() - 1) + "]");
        }

        if (t.hasClass("maskdata")) {
            t.removeClass("hasDatepicker").datepicker("destroy");
        }

        if (t.hasClass("selectpicker-custom")) {
            t.parentsUntil(t, ".bootstrap-select").replaceWith($(t));
        }

        if (full) {
            if (t.hasClass("radio")) {
                t.removeAttr("checked")
                    .parent()
                    .removeClass("active");
            }

            if (!t.hasClass("radio")) {
                t.val("");
            }
        }

        if (t.hasClass("clear")) {
            if (!t.hasClass("radio")) {
                t.val("");
            }
        }
    });

    init(c);
}

function selects(b) {
    $("select.select-estado", b).change(function() {
        var t = $(this);
        var ref = $("#" + t.attr("data-ref"));
        var api = "cidades";

        ref.html('<option value="">Carregando...</option>');

        if (ref.hasClass("selectpicker-custom")) {
            ref.selectpicker("refresh");
        }

        $.getJSON(
            CONFIG_URL + "/api/" + api + "/" + t.val() + "?callback=?",
            function(obj) {
                ref.empty();

                $(obj).each(function(k, row) {
                    var opt = $("<option></option>");

                    opt.attr("value", row.id);
                    opt.html(row.nome);

                    ref.append(opt);
                });

                if (ref.hasClass("selectpicker-custom")) {
                    ref.selectpicker("refresh");
                }
            }
        );
    });

    $("select.select-equal").change(function() {
        var t = $(this);
        var v = t.val();
        var d = $("#" + t.data("select-equal"));

        d.val(v);

        if (d.hasClass("selectpicker-custom")) {
            d.selectpicker("render");
        }
    });
}

function extraMasks(b) {
    $.fn.datepicker.dates['pt-BR'] =
        {
            days: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"],
            daysShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sab"],
            daysMin: ["Do", "Seg", "Te", "Qua", "Qui", "Sex", "Sa", "Do"],
            months: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthsShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            today: "Hoje",
            suffix: [],
            meridiem: []
        };

    $(".maskdata", b)
        .mask("00/00/0000", {
            placeholder: "__/__/____"
        })
        .datepicker({
            format: "dd/mm/yyyy",
            minDate: new Date(),
            lang: "pt-BR",
            language: "pt-BR",
            dayNamesShort: [
                "Dom",
                "Seg",
                "Ter",
                "Qua",
                "Qui",
                "Sex",
                "Sáb",
                "Dom"
            ],
            locale: "pt-br"
        });
    $(".maskhora", b).mask("00:00:00", {
        placeholder: "__:__:__"
    });
    $(".maskdatahora", b).mask("00/00/0000 00:00:00");
    $(".maskcep", b).mask("00000-000", {
        placeholder: "_____-___"
    });
    $(".maskcpf", b).mask("000.000.000-00", {
        reverse: true,
        placeholder: "___.___.___-__"
    });
    $(".maskcnpj", b).mask("00.000.000/0000-00", {
        reverse: true,
        placeholder: "__.___.___/____-__"
    });
    $(".masknis", b).mask("000.00000.00-0", {
        reverse: true,
        placeholder: "___._____.__-_"
    });
    $(".masknumv2", b).mask("#.###,##", {
        reverse: true
    });
    $(".nota", b).mask("#.#", {
        reverse: true
    });
    $(".masknumv", b).mask("000.000.000.000.000,00", {
        reverse: true
    });
    $(".number", b).mask("00", {
        reverse: true,
        placeholder: "__"
    });
    $(".cvv", b).mask("000", {
        reverse: true,
        placeholder: "___"
    });
    $(".year", b).mask("0000", {
        reverse: true,
        placeholder: "____"
    });
    $(".ncartao", b).mask("0000.0000.0000.0000", {
        reverse: true,
        placeholder: "____ ____ ____ ____"
    });

    var foneMaskBehavior = function(val) {
        return val.replace(/\D/g, "").length === 11
            ? "(00) 00000-0000"
            : "(00) 0000-00009";
    };
    var spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(foneMaskBehavior.apply({}, arguments), options);
        },
        placeholder: "(__) _____-____"
    };
    $(".masktelefone", b).mask(foneMaskBehavior, spOptions);
}

function galeria(p) {
    $(".lightgallery-photo-prim", p).click(function() {
        $(".lightgallery-photo a:eq(0)").trigger("click");
        return false;
    });
    $(".lightgallery-photo", p).lightGallery({
        selector: "a"
    });
    $(".lightgallery-photo-this", p).lightGallery({
        selector: "this"
    });
    $(".lightgallery-video-prim", p).click(function() {
        $(".lightgallery-video a:eq(0)").trigger("click");
        return false;
    });
    $(".lightgallery-video", p).lightGallery({
        selector: "a",
        youtubePlayerParams: {
            modestbranding: 1,
            showinfo: 0,
            rel: 0,
            controls: 1
        },
        vimeoPlayerParams: {
            byline: 0,
            portrait: 0,
            color: "A90707"
        }
    });
    $(".lightgallery-video-this", p).lightGallery({
        selector: "this",
        youtubePlayerParams: {
            modestbranding: 1,
            showinfo: 0,
            rel: 0,
            controls: 1
        },
        vimeoPlayerParams: {
            byline: 0,
            portrait: 0,
            color: "A90707"
        }
    });
}

function uploads(p) {
    var optionsDefault = {
        method: "POST",
        returnType: "json",
        acceptFiles: "*",
        showStatusAfterSuccess: false,
        showStatusAfterError: false,
        showDelete: true,
        fileCounterStyle: " - ",
        abortButtonClass: "btn btn-danger",
        cancelButtonClass: "btn btn-danger",
        dragDropContainerClass: "list-group-item rounded-bottom text-center",
        dragDropHoverClass: "active",
        errorClass: "ajax-file-error alert alert-danger my-2 d-block",
        uploadButtonClass: "btn btn-light",
        dragDropStr: '<span class="h6 p-3">Arraste e solte aqui!</span>',
        uploadStr: "<span class='fas fa-upload'></span> Procurar",
        abortStr: "<span class='fas fa-times'></span> Cancelar",
        cancelStr: "<span class='fas fa-times'></span> Cancelar",
        deleteStr: "<span class='fas fa-trash'></span> Excluir",
        doneStr: "<span class='fas fa-check'></span> Concluido",
        multiDragErrorStr: "Upload de multiplos aquivos não é permitido.",
        extErrorStr: "não é permitido. Extensões permitidas: ",
        duplicateErrorStr: "não é permitido. O arquivo já existe.",
        sizeErrorStr: "não é permitido. Tamanho máximo permitido: ",
        uploadErrorStr: "Upload não é permitido",
        maxFileCountErrorStr:
            " não é permitido. Os arquivos máximos permitidos são:",
        customErrorKeyStr: "error",
        statusBarWidth: "",
        dragdropWidth: "",
        uploadQueueOrder: "top",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    };

    $(".upload-anexos", p).each(function() {
        var b = $(this);
        var dTipo = b.data("up-tipo");
        var dTipoNum = b.data("up-tipo-num");
        var dLink = b.data("up-link");
        var dId = b.data("up-id");
        var dNome = b.data("up-nome");
        var dClass = b.data("up-class");
        var container = $(".files-itens", b);
        var ext;
        var tipo;
        var count = 0;

        if (dTipo === "foto") {
            ext = "jpg,png,gif,jpeg,bmp";
            tipo = 1;
        }

        if (dTipo === "arquivo") {
            ext =
                "jpg,png,gif,jpeg,bmp,pdf,doc,docx,rar,zip,xls,xlsx,jpg,png,gif,xml";
            tipo = 2;
        }

        if (dTipo === "video") {
            tipo = 3;
        }

        if (dTipoNum) {
            tipo = dTipoNum;
        }

        let folder = "gestor";
        if (dLink == "clientes-anexos") {
            folder = "web";
        }

        var options = $.extend(
            {
                url:
                    CONFIG_URL +
                    "/" +
                    folder +
                    "/" +
                    dLink +
                    "-upload/" +
                    dId +
                    "/" +
                    tipo,
                allowedTypes: ext,
                fileName: dNome,
                maxFileSize: 50 * 1048576,
                multiple: true,
                onSelect: function(files) {
                    $(".ajax-file-error", b).fadeOut(250, function() {
                        $(this).remove();
                    });

                    $(".ajax-file-upload-container", b).addClass("list-group");

                    return true;
                },
                onSuccess: function(files, response, xhr, pd) {
                    if (response["html"]) {
                        var ite = $(response["html"]);

                        extras(ite);
                        uploadsRemove(ite);

                        ite.fadeIn(250);

                        count++;

                        container.append(ite);
                    }
                },
                onError: function(files, status, message, pd) {
                    var ite = $(
                        '<div class="ajax-file-error ' +
                            dClass +
                            '" style="display:none;"></div>'
                    ).html(
                        '<div class="alert alert-danger">' + message + "</div>"
                    );

                    ite.fadeIn(250).click(function() {
                        $(this).fadeOut(250, function() {
                            $(this).remove();
                        });
                    });

                    count++;

                    container.append(ite);
                },
                customProgressBar: function(obj, s) {
                    this.statusbar = $(
                        "<div class='list-group-item list-group-item-action'></div>"
                    );
                    this.preview = $("<img class='w-100' />")
                        .width(s.previewWidth)
                        .height(s.previewHeight)
                        .appendTo(this.statusbar)
                        .hide();
                    this.filename = $("<div class='pb-2'></div>").appendTo(
                        this.statusbar
                    );

                    this.progressDiv = $("<div class='my-2 progress active'>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.progressbar = $(
                        "<div class='" +
                            obj.formGroup +
                            " progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>"
                    ).appendTo(this.progressDiv);
                    this.abort = $("<div>" + s.abortStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.cancel = $("<div>" + s.cancelStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.done = $("<div>" + s.doneStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.download = $("<div>" + s.downloadStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.del = $("<div>" + s.deleteStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();

                    this.abort.addClass("btn btn-danger");
                    this.done.addClass("btn btn-success");
                    this.download.addClass("btn btn-primary");
                    this.cancel.addClass("btn btn-danger");
                    this.del.addClass("btn btn-danger");

                    return this;
                }
            },
            optionsDefault
        );

        $(".uploads", b).uploadFile(options);

        $(".video-url", b).keypress(function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();

                $(".video-btn-add", b).trigger("click");

                return false;
            }
        });

        $(".video-btn-add", b).click(function() {
            var bt = $(this);
            var videoUrl = $(".video-url", b).val();

            bt.html(
                '<span class="fas fa-spinner fa-spin"></span> ' +
                    i18next.t("gestor.carregando")
            );

            if (videoUrl) {
                $.ajax({
                    type: "POST",
                    url:
                        CONFIG_URL +
                        "/gestor/" +
                        dLink +
                        "-upload/" +
                        dId +
                        "/" +
                        tipo,
                    data: {
                        video_url: videoUrl
                    },
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    }
                }).done(function(response) {
                    if (response["html"]) {
                        var ite = $(response["html"]);

                        extras(ite);
                        uploadsRemove(ite);

                        ite.fadeIn(250);

                        count++;

                        container.append(ite);

                        $(".video-url", b)
                            .val("")
                            .focus();
                    }
                });
            }

            bt.html(
                '<span class="fas fa-plus"></span> ' + i18next.t("gestor.add")
            );

            return false;
        });
    });

    $(".upload-anexos-unique", p).each(function() {
        var b = $(this);
        var dTipo = b.data("up-tipo");
        var dLink = b.data("up-link");
        var dId = b.data("up-id");
        var dNome = b.data("up-nome");
        var dClass = b.data("up-class");
        var container = $(".files-itens", b);
        var ext;
        var count = 0;

        if (dTipo === "foto") {
            ext = "jpg,png,gif,jpeg,bmp";
        }

        if (dTipo === "arquivo") {
            ext =
                "jpg,png,gif,jpeg,bmp,pdf,doc,docx,rar,zip,xls,xlsx,jpg,png,gif,xml";
        }

        let folder = "gestor";
       
        if (dLink == "clientes-anexos") {
            folder = "web";
        }

        var options = $.extend(
            {
                url: CONFIG_URL + "/" + folder + "/" + dLink + "-upload/" + dId,
                allowedTypes: ext,
                fileName: dNome,
                maxFileSize: 50 * 1048576,
                multiple: false,
                onSelect: function(files) {
                    $(".ajax-file-error", b).fadeOut(250, function() {
                        $(this).remove();
                    });

                    $(".ajax-file-upload-container", b).addClass("list-group");

                    $(".remove-upload-unique", container).trigger("click");

                    return true;
                },

                onSuccess: function(files, response, xhr, pd) {
                    if (response["html"]) {
                        var ite = $(response["html"]);

                        extras(ite);
                        uploadsRemove(ite);

                        ite.fadeIn(250);

                        count++;

                        container.append(ite);
                    }
                },
                onError: function(files, status, message, pd) {
                    var ite = $(
                        '<div class="ajax-file-error ' +
                            dClass +
                            '" style="display:none;"></div>'
                    ).html(
                        '<div class="alert alert-danger">' + message + "</div>"
                    );

                    ite.fadeIn(250).click(function() {
                        $(this).fadeOut(250, function() {
                            $(this).remove();
                        });
                    });

                    count++;

                    container.append(ite);
                },
                customProgressBar: function(obj, s) {
                    this.statusbar = $(
                        "<div class='list-group-item list-group-item-action'></div>"
                    );
                    this.preview = $("<img class='w-100' />")
                        .width(s.previewWidth)
                        .height(s.previewHeight)
                        .appendTo(this.statusbar)
                        .hide();
                    this.filename = $("<div class='pb-2'></div>").appendTo(
                        this.statusbar
                    );

                    this.progressDiv = $("<div class='my-2 progress active'>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.progressbar = $(
                        "<div class='" +
                            obj.formGroup +
                            " progress-bar progress-bar-striped progress-bar-animated' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100'></div>"
                    ).appendTo(this.progressDiv);
                    this.abort = $("<div>" + s.abortStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.cancel = $("<div>" + s.cancelStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.done = $("<div>" + s.doneStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.download = $("<div>" + s.downloadStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();
                    this.del = $("<div>" + s.deleteStr + "</div>")
                        .appendTo(this.statusbar)
                        .hide();

                    this.abort.addClass("btn btn-danger");
                    this.done.addClass("btn btn-success");
                    this.download.addClass("btn btn-primary");
                    this.cancel.addClass("btn btn-danger");
                    this.del.addClass("btn btn-danger");

                    return this;
                }
            },
            optionsDefault
        );

        $(".uploads", b).uploadFile(options);
    });

    uploadsRemove(p);
}

function uploadsRemove(p) {
    $(".remove-upload", p).click(function(e) {
        e.preventDefault();

        var t = $(this);
        var i = t.parentsUntil(t, ".item");
        var base = t.parentsUntil(t, ".upload-anexos");
        var dLink = base.data("up-link");
        var dNome = base.data("up-nome");
        var dId = $(".upload-id", i).val();

        let folder = "gestor";
        if (dLink == "curriculos") {
            folder = "web";
        }
        if (dLink == "solicitacoes") {
            folder = "web";
        }
        if (dLink == "advogado-solicitacoes") {
            folder = "web";
        }
        if (dLink == "posts-anexos") {
            folder = "web";
        }

        var c = bootbox.confirm({
            message: "<b>" + i18next.t("gestor.confirm_destroy") + "</b>",
            centerVertical: true,
            buttons: {
                cancel: {
                    label:
                        '<span class="fas fa-times"></span> ' +
                        i18next.t("gestor.no")
                },
                confirm: {
                    label:
                        '<span class="fas fa-check"></span> ' +
                        i18next.t("gestor.yes")
                }
            },
            callback: function(response) {
                if (response) {
                    $.ajax({
                        type: "POST",
                        url:
                            CONFIG_URL +
                            "/" +
                            folder +
                            "/" +
                            dLink +
                            "-delete/" +
                            dId,
                        data: {
                            nome: dNome
                        },
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            )
                        }
                    }).done(function(resp) {
                        if (resp[0] === "ok") {
                            i.fadeOut(250, function() {
                                $(this).remove();
                            });
                        }
                    });
                }
            }
        });

        return false;
    });

    $(".remove-upload-unique", p).click(function(e) {
        e.preventDefault();

        var t = $(this);
        var i = t.parentsUntil(t, ".item");
        var base = t.parentsUntil(t, ".upload-anexos-unique");
        var dLink = base.data("up-link");
        var dNome = base.data("up-nome");
        var dId = base.data("up-id");

        let folder = "gestor";
        if (dLink == "curriculos") {
            folder = "web";
        }
        if (dLink == "solicitacoes") {
            folder = "web";
        }
        if (dLink == "advogado-solicitacoes") {
            folder = "web";
        }
        if (dLink == "posts-anexos") {
            folder = "web";
        }

        var c = bootbox.confirm({
            message: "<b>" + i18next.t("gestor.confirm_destroy") + "</b>",
            centerVertical: true,
            buttons: {
                cancel: {
                    label:
                        '<span class="fas fa-times"></span> ' +
                        i18next.t("gestor.no")
                },
                confirm: {
                    label:
                        '<span class="fas fa-check"></span> ' +
                        i18next.t("gestor.yes")
                }
            },
            callback: function(response) {
                if (response) {
                    $.ajax({
                        type: "POST",
                        url:
                            CONFIG_URL +
                            "/" +
                            folder +
                            "/" +
                            dLink +
                            "-delete/" +
                            dId,
                        data: {
                            nome: dNome
                        },
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            )
                        }
                    }).done(function(resp) {
                        if (resp[0] === "ok") {
                            i.fadeOut(250, function() {
                                $(this).remove();
                            });
                        }
                    });
                }
            }
        });

        return false;
    });
}

function actionMenuClientes(p) {
    
    if ($("[name='anchor']").length) {
        window.location = "#" + $("[name='anchor']").val();
    }

    tinymce.init({
        selector: "textarea.tinymce",
        //document_base_url: CONFIG_URL + (PATH_GET['modulo'] == "configuracoes-ajuda" ? "" : ""),
        content_css: CONFIG_URL + "/css/tinymce.css",
        language: "pt_BR",
        toolbar:
            "undo redo | styleselect fontsizeselect | " +
            "bold italic underline | forecolor backcolor | " +
            "alignleft aligncenter alignright alignjustify | " +
            "bullist numlist | outdent indent | " +
            "table | link unlink | visualblocks",
        iconfonts_selector: ".fa, .fab, .fal, .far, .fas, .glyphicon",
        height: "480px",
        plugins:
            "iconfonts, advlist, anchor, autolink, autoresize, charmap, code, codesample, directionality, fullscreen, help, hr, image, imagetools, link, lists, media, paste, preview, print, searchreplace, tabfocus, table, toc, visualblocks, visualchars, wordcount"
    });
}
