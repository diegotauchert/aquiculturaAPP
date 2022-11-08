require("./bootstrap");

const tinymce = require("tinymce/tinymce");
require("./tinymce");

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
    ajustaNavbar(p);
    extras(p);
    clones(p);
    selects(p);
    extraMasks(p);
    checkAll(p);
    uploads(p);
}

function ajustaNavbar(p) {
    $(window).resize(function() {
        $(".navbar.fixed-top", p).each(function() {
            var h = $(this).outerHeight();

            $(this)
                .next()
                .css("height", h + "px");
        });
    });

    $(".navbar.fixed-top", p).each(function() {
        var h = $(this).outerHeight();

        $(this).after(
            $("<div>")
                .addClass("navbar-back")
                .css("height", h + "px")
        );
    });

    $(".navbar-nav .dropdown-item.active", p).each(function() {
        $(this)
            .parentsUntil(this, "li")
            .find(">a")
            .addClass("active");
    });

    $('[data-toggle="offcanvas"]', p).click(function() {
        $(".offcanvas-collapse", p).toggleClass("open");
    });
}

function extras(b) {
    $('[data-toggle="popover"]').popover({
        html: true,
        container: "body"
    });

    $('[data-toggle="tooltip"], .o-tooltip').tooltip({
        html: true,
        container: "body"
    });

    $(".seo", b).change(function() {
        var t = $(this);
        var v = t.val();

        t.val(accents(v));
    });

    $(".normatize", b).change(function() {
        var t = $(this);
        var ref = t.data("ref");
        var v = t.val();

        $("#" + ref).val(urlSlugMatch(accents(v)));
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

    $(".maxlength", b).each(function() {
        $(this)
            .keyup(function() {
                maxlength($(this));
            })
            .trigger("keyup");
    });

    if (!document.getElementById("login")) {
        $(".view-responsive > .btn-group > .btn", b).click(function() {
            var e = $(this);
            var p = e.parentsUntil(e, ".btn-group");
            var v = e.parentsUntil(e, ".view-responsive");

            $(".btn", p).removeClass("active");

            if (e.hasClass("smart")) {
                e.addClass("active");

                if ($("html").outerWidth() < 321) {
                    v.width("100%");
                } else {
                    v.width("320px");
                }
            }

            if (e.hasClass("tablet")) {
                e.addClass("active");

                if ($("html").outerWidth() < 769) {
                    v.width("100%");
                } else {
                    v.width("768px");
                }
            }

            if (e.hasClass("desk")) {
                e.addClass("active");

                if ($("html").outerWidth() > 1024) {
                    v.width("100%");
                } else {
                    v.width("1024px");
                }
            }

            return false;
        });

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
        var num = parseInt(i.prop("id").match(/\d+/g), 10) + 1;
        if (isNaN(num)) {
            num = 1;
        }

        var p = t.parentsUntil(t, ".clones");
        var tot = $(".item", p).length;
        var c = i.clone().prop("id", "clone-" + num);

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
        var minNumber = 10;
        var maxNumber = 1000;

        var t = $(this);
        var id = t.data("clone-id") + "_";

        if (id) {
            var idNew =
                id +
                1 +
                Math.floor(Math.random() * (maxNumber + 1) + minNumber);
            t.attr("id", idNew);
            t.closest("div")
                .find("label")
                .attr("for", idNew);

            if (t.data("clone-ref")) {
                t.attr("data-ref", t.data("clone-ref") + "_" + (tot + 1));
            }
        }

        if (t.hasClass("radio")) {
            alert(t.data("clone-id") + "[" + (c.index() - 1) + "]");
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
    $(".maskdate", b).mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $(".maskdata", b)
        .mask("00/00/0000", {
            placeholder: "__/__/____"
        })
        .datepicker({
            format: "dd/mm/yyyy",
            lang: "pt-BR",
            locale: "pt-br"
        });
    $(".maskhora", b).mask("00:00:00", {
        placeholder: "__:__:__"
    });
    $(".maskhorario", b).mask("00:00", {
        placeholder: "__:__"
    });
    $(".maskdatahora", b).mask("00/00/0000 00:00:00");
    $(".masknumerocartao", b).mask("0000.0000.0000.0000");
    $(".maskcep", b).mask("00000-000", {
        placeholder: "_____-___"
    });
    $(".maskmes", b).mask("00", {
        reverse: true,
        placeholder: "__"
    });
    $(".maskano", b).mask("0000", {
        reverse: true,
        placeholder: "____"
    });
    $(".maskfive", b).mask("00000", {
        reverse: true,
        placeholder: ""
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
        reverse: true,
        placeholder: "__,__"
    });
    $(".masknumv3", b).mask("###.###.###.###.###,##", {
        reverse: true,
        placeholder: "__,__"
    });
    $(".masknumv", b).mask("000.000.000.000.000,00", {
        reverse: true
    });
    $(".maskcomissao", b).mask("00.00", {
        reverse: true
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

    /*$("div.files-ordem", b).sortable({
        forcePlaceholderSize: true,
        opacity: .5,
        placeholder: "card card-body border-primary bg-alpha-primary col-sm-6 col-md-4 col-lg-3 my-auto"
    });*/
}

function maxlength(b) {
    var target = $(".content-countdown", $(b).parent());
    var max = $(b).attr("maxlength");
    var len = $(b).val().length;
    var remain = max - len;

    if (len > max) {
        var val = $(b).val();
        $(b).val(val.substr(0, max));

        remain = 0;
    }

    target.html(remain);
}

function checkAll(b) {
    $("input.all-ite[type=checkbox]", b).click(function() {
        var par = $(this).parentsUntil(this, "table");
        var ck = this.checked;

        $("tbody input[type=checkbox]", par).each(function() {
            var par = $(this).parentsUntil(this, "tr");
            this.checked = ck;

            if ($(this).prop("checked")) {
                $(par).addClass("table-active");
            } else {
                $(par).removeClass("table-active");
            }
        });
    });

    $("table tbody input[type=checkbox]", b).click(function() {
        var par = $(this).parentsUntil(this, "tr");
        var tot = $("table tbody input[type=checkbox]", b).length;
        var tot_check = $("table tbody input[type=checkbox]:checked", b).length;

        if (tot_check > 0) {
            if (tot_check === tot) {
                $("input.all-ite[type=checkbox]", b).prop("checked", true);
                $("input.all-ite[type=checkbox]", b).prop(
                    "indeterminate",
                    false
                );
            } else {
                $("input.all-ite[type=checkbox]", b).prop("checked", false);
                $("input.all-ite[type=checkbox]", b).prop(
                    "indeterminate",
                    true
                );
            }
        } else {
            $("input.all-ite[type=checkbox]", b).prop("checked", false);
            $("input.all-ite[type=checkbox]", b).prop("indeterminate", false);
        }

        if ($(this).prop("checked")) {
            $(par).addClass("table-active");
        } else {
            $(par).removeClass("table-active");
        }
    });

    $('input[type="checkbox"]:not(.check-unique)').change(function(e) {
        var checked = $(this).prop("checked"),
            container = $(this)
                .parent()
                .parent()
                .parent(),
            siblings = container.siblings();

        container.find('input[type="checkbox"]').prop({
            indeterminate: false,
            checked: checked
        });

        function checkSiblings(el) {
            var parent = el
                    .parent()
                    .parent()
                    .parent(),
                all = true;

            el.parent()
                .siblings()
                .each(function() {
                    return (all =
                        $(this)
                            .children('input[type="checkbox"]')
                            .prop("checked") === checked);
                });

            if (all && checked) {
                parent.children('input[type="checkbox"]').prop({
                    indeterminate: false,
                    checked: checked
                });

                checkSiblings(parent);
            } else if (all && !checked) {
                parent
                    .children('input[type="checkbox"]')
                    .prop("checked", checked);
                parent
                    .children('input[type="checkbox"]')
                    .prop(
                        "indeterminate",
                        parent.find('input[type="checkbox"]:checked').length > 0
                    );
                checkSiblings(parent);
            } else {
                console.log(el.parents(el.parent()));

                el.parents(".card")
                    .children(
                        '.card-header > custom-control > input.mark-all[type="checkbox"]'
                    )
                    .prop({
                        indeterminate: true,
                        checked: false
                    });
            }
        }

        checkSiblings(container);
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

        var options = $.extend(
            {
                url:
                    CONFIG_URL +
                    "/gestor/" +
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

        var options = $.extend(
            {
                url: CONFIG_URL + "/gestor/" + dLink + "-upload/" + dId,
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
                        url: CONFIG_URL + "/gestor/" + dLink + "-delete/" + dId,
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
                        url: CONFIG_URL + "/gestor/" + dLink + "-delete/" + dId,
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
