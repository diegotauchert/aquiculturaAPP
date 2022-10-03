function initSlimscroll() {
    $(".slimscroll").slimscroll({
        height: "auto",
        position: "right",
        size: "7px",
        color: "#e6eaf5",
        opacity: "1",
        wheelStep: 5,
        touchScrollStep: 50
    });
}

function initMetisMenu() {
    //metis menu
    $("#main_menu_side_nav").metisMenu();
    $(".metismenu").metisMenu();
}

function initLeftMenuCollapse() {
    // Left menu collapse
    $(".button-menu-mobile").on("click", function(event) {
        event.preventDefault();
        $("body").toggleClass("enlarge-menu");
        initSlimscroll();
    });
}

function initEnlarge() {
    if ($(window).width() < 1025) {
        $("body").addClass("enlarge-menu");
    } else {
        if ($("body").data("keep-enlarged") != true)
            $("body").removeClass("enlarge-menu");
    }
}

function initSerach() {
    $(".search-btn").on("click", function() {
        var targetId = $(this).data("target");
        var $searchBar;
        if (targetId) {
            $searchBar = $(targetId);
            $searchBar.toggleClass("open");
        }
    });
}

function initMainIconMenu() {
    $(".main-icon-menu .nav-link").on("click", function(e) {
        e.preventDefault();
        $(this).addClass("active");
        $(this)
            .siblings()
            .removeClass("active");
        $(".main-menu-inner").addClass("active");
        var targ = $(this).attr("href");
        $(targ).addClass("active");
        $(targ)
            .siblings()
            .removeClass("active");
    });
}

function initTooltipPlugin() {
    $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="tooltip-custom"]').tooltip({
        template:
            '<div class="tooltip tooltip-custom" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
    });
}

function initActiveMenu() {
    // === following js will activate the menu in left side bar based on url ====
    $(".left-sidenav a").each(function() {
        var pageUrl = window.location.href.split(/[?#]/)[0];

        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this)
                .parent()
                .parent()
                .addClass("in");
            $(this)
                .parent()
                .parent()
                .addClass("mm-show");
            $(this)
                .parent()
                .parent()
                .prev()
                .addClass("active");
            $(this)
                .parent()
                .parent()
                .parent()
                .addClass("active");
            $(this)
                .parent()
                .parent()
                .parent()
                .addClass("mm-active");
            $(this)
                .parent()
                .parent()
                .parent()
                .parent()
                .addClass("in");
            $(this)
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .addClass("active");
            $(this)
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .parent()
                .addClass("active");
            var menu = $(this)
                .closest(".main-icon-menu-pane")
                .attr("id");
            $("a[href='#" + menu + "']").addClass("active");
        }

        if (pageUrl.indexOf("editar") > 0 || pageUrl.indexOf("novo") > 0) {
            $("#MetricaHospital").addClass("active");
        }
    });
}

function init() {
    initSlimscroll();
    initMetisMenu();
    initLeftMenuCollapse();
    initEnlarge();
    initSerach();
    initMainIconMenu();
    initTooltipPlugin();
    initActiveMenu();
    Waves.init();
}

init();

$(".inline").datepicker({
    todayHighlight: true
});

if ($("#datatable").length) {
    $("#datatable").DataTable({
        order: [],
        language: {
            url:
                "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json"
        }
    });
}
