/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function initSlimscroll() {\n  $(\".slimscroll\").slimscroll({\n    height: \"auto\",\n    position: \"right\",\n    size: \"7px\",\n    color: \"#e6eaf5\",\n    opacity: \"1\",\n    wheelStep: 5,\n    touchScrollStep: 50\n  });\n}\n\nfunction initMetisMenu() {\n  //metis menu\n  $(\"#main_menu_side_nav\").metisMenu();\n  $(\".metismenu\").metisMenu();\n}\n\nfunction initLeftMenuCollapse() {\n  // Left menu collapse\n  $(\".button-menu-mobile\").on(\"click\", function (event) {\n    event.preventDefault();\n    $(\"body\").toggleClass(\"enlarge-menu\");\n    initSlimscroll();\n  });\n}\n\nfunction initEnlarge() {\n  if ($(window).width() < 1025) {\n    $(\"body\").addClass(\"enlarge-menu\");\n  } else {\n    if ($(\"body\").data(\"keep-enlarged\") != true) $(\"body\").removeClass(\"enlarge-menu\");\n  }\n}\n\nfunction initSerach() {\n  $(\".search-btn\").on(\"click\", function () {\n    var targetId = $(this).data(\"target\");\n    var $searchBar;\n\n    if (targetId) {\n      $searchBar = $(targetId);\n      $searchBar.toggleClass(\"open\");\n    }\n  });\n}\n\nfunction initMainIconMenu() {\n  $(\".main-icon-menu .nav-link\").on(\"click\", function (e) {\n    e.preventDefault();\n    $(this).addClass(\"active\");\n    $(this).siblings().removeClass(\"active\");\n    $(\".main-menu-inner\").addClass(\"active\");\n    var targ = $(this).attr(\"href\");\n    $(targ).addClass(\"active\");\n    $(targ).siblings().removeClass(\"active\");\n  });\n}\n\nfunction initTooltipPlugin() {\n  $.fn.tooltip && $('[data-toggle=\"tooltip\"]').tooltip();\n  $('[data-toggle=\"tooltip-custom\"]').tooltip({\n    template: '<div class=\"tooltip tooltip-custom\" role=\"tooltip\"><div class=\"arrow\"></div><div class=\"tooltip-inner\"></div></div>'\n  });\n}\n\nfunction initActiveMenu() {\n  // === following js will activate the menu in left side bar based on url ====\n  $(\".left-sidenav a\").each(function () {\n    var pageUrl = window.location.href.split(/[?#]/)[0];\n\n    if (this.href == pageUrl) {\n      $(this).addClass(\"active\");\n      $(this).parent().parent().addClass(\"in\");\n      $(this).parent().parent().addClass(\"mm-show\");\n      $(this).parent().parent().prev().addClass(\"active\");\n      $(this).parent().parent().parent().addClass(\"active\");\n      $(this).parent().parent().parent().addClass(\"mm-active\");\n      $(this).parent().parent().parent().parent().addClass(\"in\");\n      $(this).parent().parent().parent().parent().parent().addClass(\"active\");\n      $(this).parent().parent().parent().parent().parent().parent().addClass(\"active\");\n      var menu = $(this).closest(\".main-icon-menu-pane\").attr(\"id\");\n      $(\"a[href='#\" + menu + \"']\").addClass(\"active\");\n    }\n\n    if (pageUrl.indexOf(\"editar\") > 0 || pageUrl.indexOf(\"novo\") > 0) {\n      $(\"#MetricaHospital\").addClass(\"active\");\n    }\n  });\n}\n\nfunction init() {\n  initSlimscroll();\n  initMetisMenu();\n  initLeftMenuCollapse();\n  initEnlarge();\n  initSerach();\n  initMainIconMenu();\n  initTooltipPlugin();\n  initActiveMenu();\n  Waves.init();\n}\n\ninit();\n$(\".inline\").datepicker({\n  todayHighlight: true\n});\n\nif ($(\"#datatable\").length) {\n  $(\"#datatable\").DataTable({\n    order: [],\n    language: {\n      url: \"//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese.json\"\n    }\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvYXBwLmpzPzZkNDAiXSwibmFtZXMiOlsiaW5pdFNsaW1zY3JvbGwiLCIkIiwic2xpbXNjcm9sbCIsImhlaWdodCIsInBvc2l0aW9uIiwic2l6ZSIsImNvbG9yIiwib3BhY2l0eSIsIndoZWVsU3RlcCIsInRvdWNoU2Nyb2xsU3RlcCIsImluaXRNZXRpc01lbnUiLCJtZXRpc01lbnUiLCJpbml0TGVmdE1lbnVDb2xsYXBzZSIsIm9uIiwiZXZlbnQiLCJwcmV2ZW50RGVmYXVsdCIsInRvZ2dsZUNsYXNzIiwiaW5pdEVubGFyZ2UiLCJ3aW5kb3ciLCJ3aWR0aCIsImFkZENsYXNzIiwiZGF0YSIsInJlbW92ZUNsYXNzIiwiaW5pdFNlcmFjaCIsInRhcmdldElkIiwiJHNlYXJjaEJhciIsImluaXRNYWluSWNvbk1lbnUiLCJlIiwic2libGluZ3MiLCJ0YXJnIiwiYXR0ciIsImluaXRUb29sdGlwUGx1Z2luIiwiZm4iLCJ0b29sdGlwIiwidGVtcGxhdGUiLCJpbml0QWN0aXZlTWVudSIsImVhY2giLCJwYWdlVXJsIiwibG9jYXRpb24iLCJocmVmIiwic3BsaXQiLCJwYXJlbnQiLCJwcmV2IiwibWVudSIsImNsb3Nlc3QiLCJpbmRleE9mIiwiaW5pdCIsIldhdmVzIiwiZGF0ZXBpY2tlciIsInRvZGF5SGlnaGxpZ2h0IiwibGVuZ3RoIiwiRGF0YVRhYmxlIiwib3JkZXIiLCJsYW5ndWFnZSIsInVybCJdLCJtYXBwaW5ncyI6IkFBQUEsU0FBU0EsY0FBVCxHQUEwQjtFQUN0QkMsQ0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQkMsVUFBakIsQ0FBNEI7SUFDeEJDLE1BQU0sRUFBRSxNQURnQjtJQUV4QkMsUUFBUSxFQUFFLE9BRmM7SUFHeEJDLElBQUksRUFBRSxLQUhrQjtJQUl4QkMsS0FBSyxFQUFFLFNBSmlCO0lBS3hCQyxPQUFPLEVBQUUsR0FMZTtJQU14QkMsU0FBUyxFQUFFLENBTmE7SUFPeEJDLGVBQWUsRUFBRTtFQVBPLENBQTVCO0FBU0g7O0FBRUQsU0FBU0MsYUFBVCxHQUF5QjtFQUNyQjtFQUNBVCxDQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5QlUsU0FBekI7RUFDQVYsQ0FBQyxDQUFDLFlBQUQsQ0FBRCxDQUFnQlUsU0FBaEI7QUFDSDs7QUFFRCxTQUFTQyxvQkFBVCxHQUFnQztFQUM1QjtFQUNBWCxDQUFDLENBQUMscUJBQUQsQ0FBRCxDQUF5QlksRUFBekIsQ0FBNEIsT0FBNUIsRUFBcUMsVUFBU0MsS0FBVCxFQUFnQjtJQUNqREEsS0FBSyxDQUFDQyxjQUFOO0lBQ0FkLENBQUMsQ0FBQyxNQUFELENBQUQsQ0FBVWUsV0FBVixDQUFzQixjQUF0QjtJQUNBaEIsY0FBYztFQUNqQixDQUpEO0FBS0g7O0FBRUQsU0FBU2lCLFdBQVQsR0FBdUI7RUFDbkIsSUFBSWhCLENBQUMsQ0FBQ2lCLE1BQUQsQ0FBRCxDQUFVQyxLQUFWLEtBQW9CLElBQXhCLEVBQThCO0lBQzFCbEIsQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVbUIsUUFBVixDQUFtQixjQUFuQjtFQUNILENBRkQsTUFFTztJQUNILElBQUluQixDQUFDLENBQUMsTUFBRCxDQUFELENBQVVvQixJQUFWLENBQWUsZUFBZixLQUFtQyxJQUF2QyxFQUNJcEIsQ0FBQyxDQUFDLE1BQUQsQ0FBRCxDQUFVcUIsV0FBVixDQUFzQixjQUF0QjtFQUNQO0FBQ0o7O0FBRUQsU0FBU0MsVUFBVCxHQUFzQjtFQUNsQnRCLENBQUMsQ0FBQyxhQUFELENBQUQsQ0FBaUJZLEVBQWpCLENBQW9CLE9BQXBCLEVBQTZCLFlBQVc7SUFDcEMsSUFBSVcsUUFBUSxHQUFHdkIsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUFRb0IsSUFBUixDQUFhLFFBQWIsQ0FBZjtJQUNBLElBQUlJLFVBQUo7O0lBQ0EsSUFBSUQsUUFBSixFQUFjO01BQ1ZDLFVBQVUsR0FBR3hCLENBQUMsQ0FBQ3VCLFFBQUQsQ0FBZDtNQUNBQyxVQUFVLENBQUNULFdBQVgsQ0FBdUIsTUFBdkI7SUFDSDtFQUNKLENBUEQ7QUFRSDs7QUFFRCxTQUFTVSxnQkFBVCxHQUE0QjtFQUN4QnpCLENBQUMsQ0FBQywyQkFBRCxDQUFELENBQStCWSxFQUEvQixDQUFrQyxPQUFsQyxFQUEyQyxVQUFTYyxDQUFULEVBQVk7SUFDbkRBLENBQUMsQ0FBQ1osY0FBRjtJQUNBZCxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFtQixRQUFSLENBQWlCLFFBQWpCO0lBQ0FuQixDQUFDLENBQUMsSUFBRCxDQUFELENBQ0syQixRQURMLEdBRUtOLFdBRkwsQ0FFaUIsUUFGakI7SUFHQXJCLENBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCbUIsUUFBdEIsQ0FBK0IsUUFBL0I7SUFDQSxJQUFJUyxJQUFJLEdBQUc1QixDQUFDLENBQUMsSUFBRCxDQUFELENBQVE2QixJQUFSLENBQWEsTUFBYixDQUFYO0lBQ0E3QixDQUFDLENBQUM0QixJQUFELENBQUQsQ0FBUVQsUUFBUixDQUFpQixRQUFqQjtJQUNBbkIsQ0FBQyxDQUFDNEIsSUFBRCxDQUFELENBQ0tELFFBREwsR0FFS04sV0FGTCxDQUVpQixRQUZqQjtFQUdILENBWkQ7QUFhSDs7QUFFRCxTQUFTUyxpQkFBVCxHQUE2QjtFQUN6QjlCLENBQUMsQ0FBQytCLEVBQUYsQ0FBS0MsT0FBTCxJQUFnQmhDLENBQUMsQ0FBQyx5QkFBRCxDQUFELENBQTZCZ0MsT0FBN0IsRUFBaEI7RUFDQWhDLENBQUMsQ0FBQyxnQ0FBRCxDQUFELENBQW9DZ0MsT0FBcEMsQ0FBNEM7SUFDeENDLFFBQVEsRUFDSjtFQUZvQyxDQUE1QztBQUlIOztBQUVELFNBQVNDLGNBQVQsR0FBMEI7RUFDdEI7RUFDQWxDLENBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCbUMsSUFBckIsQ0FBMEIsWUFBVztJQUNqQyxJQUFJQyxPQUFPLEdBQUduQixNQUFNLENBQUNvQixRQUFQLENBQWdCQyxJQUFoQixDQUFxQkMsS0FBckIsQ0FBMkIsTUFBM0IsRUFBbUMsQ0FBbkMsQ0FBZDs7SUFFQSxJQUFJLEtBQUtELElBQUwsSUFBYUYsT0FBakIsRUFBMEI7TUFDdEJwQyxDQUFDLENBQUMsSUFBRCxDQUFELENBQVFtQixRQUFSLENBQWlCLFFBQWpCO01BQ0FuQixDQUFDLENBQUMsSUFBRCxDQUFELENBQ0t3QyxNQURMLEdBRUtBLE1BRkwsR0FHS3JCLFFBSEwsQ0FHYyxJQUhkO01BSUFuQixDQUFDLENBQUMsSUFBRCxDQUFELENBQ0t3QyxNQURMLEdBRUtBLE1BRkwsR0FHS3JCLFFBSEwsQ0FHYyxTQUhkO01BSUFuQixDQUFDLENBQUMsSUFBRCxDQUFELENBQ0t3QyxNQURMLEdBRUtBLE1BRkwsR0FHS0MsSUFITCxHQUlLdEIsUUFKTCxDQUljLFFBSmQ7TUFLQW5CLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FDS3dDLE1BREwsR0FFS0EsTUFGTCxHQUdLQSxNQUhMLEdBSUtyQixRQUpMLENBSWMsUUFKZDtNQUtBbkIsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUNLd0MsTUFETCxHQUVLQSxNQUZMLEdBR0tBLE1BSEwsR0FJS3JCLFFBSkwsQ0FJYyxXQUpkO01BS0FuQixDQUFDLENBQUMsSUFBRCxDQUFELENBQ0t3QyxNQURMLEdBRUtBLE1BRkwsR0FHS0EsTUFITCxHQUlLQSxNQUpMLEdBS0tyQixRQUxMLENBS2MsSUFMZDtNQU1BbkIsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUNLd0MsTUFETCxHQUVLQSxNQUZMLEdBR0tBLE1BSEwsR0FJS0EsTUFKTCxHQUtLQSxNQUxMLEdBTUtyQixRQU5MLENBTWMsUUFOZDtNQU9BbkIsQ0FBQyxDQUFDLElBQUQsQ0FBRCxDQUNLd0MsTUFETCxHQUVLQSxNQUZMLEdBR0tBLE1BSEwsR0FJS0EsTUFKTCxHQUtLQSxNQUxMLEdBTUtBLE1BTkwsR0FPS3JCLFFBUEwsQ0FPYyxRQVBkO01BUUEsSUFBSXVCLElBQUksR0FBRzFDLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FDTjJDLE9BRE0sQ0FDRSxzQkFERixFQUVOZCxJQUZNLENBRUQsSUFGQyxDQUFYO01BR0E3QixDQUFDLENBQUMsY0FBYzBDLElBQWQsR0FBcUIsSUFBdEIsQ0FBRCxDQUE2QnZCLFFBQTdCLENBQXNDLFFBQXRDO0lBQ0g7O0lBRUQsSUFBSWlCLE9BQU8sQ0FBQ1EsT0FBUixDQUFnQixRQUFoQixJQUE0QixDQUE1QixJQUFpQ1IsT0FBTyxDQUFDUSxPQUFSLENBQWdCLE1BQWhCLElBQTBCLENBQS9ELEVBQWtFO01BQzlENUMsQ0FBQyxDQUFDLGtCQUFELENBQUQsQ0FBc0JtQixRQUF0QixDQUErQixRQUEvQjtJQUNIO0VBQ0osQ0ExREQ7QUEyREg7O0FBRUQsU0FBUzBCLElBQVQsR0FBZ0I7RUFDWjlDLGNBQWM7RUFDZFUsYUFBYTtFQUNiRSxvQkFBb0I7RUFDcEJLLFdBQVc7RUFDWE0sVUFBVTtFQUNWRyxnQkFBZ0I7RUFDaEJLLGlCQUFpQjtFQUNqQkksY0FBYztFQUNkWSxLQUFLLENBQUNELElBQU47QUFDSDs7QUFFREEsSUFBSTtBQUVKN0MsQ0FBQyxDQUFDLFNBQUQsQ0FBRCxDQUFhK0MsVUFBYixDQUF3QjtFQUNwQkMsY0FBYyxFQUFFO0FBREksQ0FBeEI7O0FBSUEsSUFBSWhELENBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0JpRCxNQUFwQixFQUE0QjtFQUN4QmpELENBQUMsQ0FBQyxZQUFELENBQUQsQ0FBZ0JrRCxTQUFoQixDQUEwQjtJQUN0QkMsS0FBSyxFQUFFLEVBRGU7SUFFdEJDLFFBQVEsRUFBRTtNQUNOQyxHQUFHLEVBQ0M7SUFGRTtFQUZZLENBQTFCO0FBT0giLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvYXBwLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiZnVuY3Rpb24gaW5pdFNsaW1zY3JvbGwoKSB7XG4gICAgJChcIi5zbGltc2Nyb2xsXCIpLnNsaW1zY3JvbGwoe1xuICAgICAgICBoZWlnaHQ6IFwiYXV0b1wiLFxuICAgICAgICBwb3NpdGlvbjogXCJyaWdodFwiLFxuICAgICAgICBzaXplOiBcIjdweFwiLFxuICAgICAgICBjb2xvcjogXCIjZTZlYWY1XCIsXG4gICAgICAgIG9wYWNpdHk6IFwiMVwiLFxuICAgICAgICB3aGVlbFN0ZXA6IDUsXG4gICAgICAgIHRvdWNoU2Nyb2xsU3RlcDogNTBcbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gaW5pdE1ldGlzTWVudSgpIHtcbiAgICAvL21ldGlzIG1lbnVcbiAgICAkKFwiI21haW5fbWVudV9zaWRlX25hdlwiKS5tZXRpc01lbnUoKTtcbiAgICAkKFwiLm1ldGlzbWVudVwiKS5tZXRpc01lbnUoKTtcbn1cblxuZnVuY3Rpb24gaW5pdExlZnRNZW51Q29sbGFwc2UoKSB7XG4gICAgLy8gTGVmdCBtZW51IGNvbGxhcHNlXG4gICAgJChcIi5idXR0b24tbWVudS1tb2JpbGVcIikub24oXCJjbGlja1wiLCBmdW5jdGlvbihldmVudCkge1xuICAgICAgICBldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICAkKFwiYm9keVwiKS50b2dnbGVDbGFzcyhcImVubGFyZ2UtbWVudVwiKTtcbiAgICAgICAgaW5pdFNsaW1zY3JvbGwoKTtcbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gaW5pdEVubGFyZ2UoKSB7XG4gICAgaWYgKCQod2luZG93KS53aWR0aCgpIDwgMTAyNSkge1xuICAgICAgICAkKFwiYm9keVwiKS5hZGRDbGFzcyhcImVubGFyZ2UtbWVudVwiKTtcbiAgICB9IGVsc2Uge1xuICAgICAgICBpZiAoJChcImJvZHlcIikuZGF0YShcImtlZXAtZW5sYXJnZWRcIikgIT0gdHJ1ZSlcbiAgICAgICAgICAgICQoXCJib2R5XCIpLnJlbW92ZUNsYXNzKFwiZW5sYXJnZS1tZW51XCIpO1xuICAgIH1cbn1cblxuZnVuY3Rpb24gaW5pdFNlcmFjaCgpIHtcbiAgICAkKFwiLnNlYXJjaC1idG5cIikub24oXCJjbGlja1wiLCBmdW5jdGlvbigpIHtcbiAgICAgICAgdmFyIHRhcmdldElkID0gJCh0aGlzKS5kYXRhKFwidGFyZ2V0XCIpO1xuICAgICAgICB2YXIgJHNlYXJjaEJhcjtcbiAgICAgICAgaWYgKHRhcmdldElkKSB7XG4gICAgICAgICAgICAkc2VhcmNoQmFyID0gJCh0YXJnZXRJZCk7XG4gICAgICAgICAgICAkc2VhcmNoQmFyLnRvZ2dsZUNsYXNzKFwib3BlblwiKTtcbiAgICAgICAgfVxuICAgIH0pO1xufVxuXG5mdW5jdGlvbiBpbml0TWFpbkljb25NZW51KCkge1xuICAgICQoXCIubWFpbi1pY29uLW1lbnUgLm5hdi1saW5rXCIpLm9uKFwiY2xpY2tcIiwgZnVuY3Rpb24oZSkge1xuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgICQodGhpcykuYWRkQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgICQodGhpcylcbiAgICAgICAgICAgIC5zaWJsaW5ncygpXG4gICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgICQoXCIubWFpbi1tZW51LWlubmVyXCIpLmFkZENsYXNzKFwiYWN0aXZlXCIpO1xuICAgICAgICB2YXIgdGFyZyA9ICQodGhpcykuYXR0cihcImhyZWZcIik7XG4gICAgICAgICQodGFyZykuYWRkQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgICQodGFyZylcbiAgICAgICAgICAgIC5zaWJsaW5ncygpXG4gICAgICAgICAgICAucmVtb3ZlQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIGluaXRUb29sdGlwUGx1Z2luKCkge1xuICAgICQuZm4udG9vbHRpcCAmJiAkKCdbZGF0YS10b2dnbGU9XCJ0b29sdGlwXCJdJykudG9vbHRpcCgpO1xuICAgICQoJ1tkYXRhLXRvZ2dsZT1cInRvb2x0aXAtY3VzdG9tXCJdJykudG9vbHRpcCh7XG4gICAgICAgIHRlbXBsYXRlOlxuICAgICAgICAgICAgJzxkaXYgY2xhc3M9XCJ0b29sdGlwIHRvb2x0aXAtY3VzdG9tXCIgcm9sZT1cInRvb2x0aXBcIj48ZGl2IGNsYXNzPVwiYXJyb3dcIj48L2Rpdj48ZGl2IGNsYXNzPVwidG9vbHRpcC1pbm5lclwiPjwvZGl2PjwvZGl2PidcbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gaW5pdEFjdGl2ZU1lbnUoKSB7XG4gICAgLy8gPT09IGZvbGxvd2luZyBqcyB3aWxsIGFjdGl2YXRlIHRoZSBtZW51IGluIGxlZnQgc2lkZSBiYXIgYmFzZWQgb24gdXJsID09PT1cbiAgICAkKFwiLmxlZnQtc2lkZW5hdiBhXCIpLmVhY2goZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBwYWdlVXJsID0gd2luZG93LmxvY2F0aW9uLmhyZWYuc3BsaXQoL1s/I10vKVswXTtcblxuICAgICAgICBpZiAodGhpcy5ocmVmID09IHBhZ2VVcmwpIHtcbiAgICAgICAgICAgICQodGhpcykuYWRkQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgICAgICAkKHRoaXMpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiaW5cIik7XG4gICAgICAgICAgICAkKHRoaXMpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwibW0tc2hvd1wiKTtcbiAgICAgICAgICAgICQodGhpcylcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAucHJldigpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWN0aXZlXCIpO1xuICAgICAgICAgICAgJCh0aGlzKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFjdGl2ZVwiKTtcbiAgICAgICAgICAgICQodGhpcylcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAucGFyZW50KClcbiAgICAgICAgICAgICAgICAuYWRkQ2xhc3MoXCJtbS1hY3RpdmVcIik7XG4gICAgICAgICAgICAkKHRoaXMpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiaW5cIik7XG4gICAgICAgICAgICAkKHRoaXMpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLnBhcmVudCgpXG4gICAgICAgICAgICAgICAgLmFkZENsYXNzKFwiYWN0aXZlXCIpO1xuICAgICAgICAgICAgJCh0aGlzKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5wYXJlbnQoKVxuICAgICAgICAgICAgICAgIC5hZGRDbGFzcyhcImFjdGl2ZVwiKTtcbiAgICAgICAgICAgIHZhciBtZW51ID0gJCh0aGlzKVxuICAgICAgICAgICAgICAgIC5jbG9zZXN0KFwiLm1haW4taWNvbi1tZW51LXBhbmVcIilcbiAgICAgICAgICAgICAgICAuYXR0cihcImlkXCIpO1xuICAgICAgICAgICAgJChcImFbaHJlZj0nI1wiICsgbWVudSArIFwiJ11cIikuYWRkQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgIH1cblxuICAgICAgICBpZiAocGFnZVVybC5pbmRleE9mKFwiZWRpdGFyXCIpID4gMCB8fCBwYWdlVXJsLmluZGV4T2YoXCJub3ZvXCIpID4gMCkge1xuICAgICAgICAgICAgJChcIiNNZXRyaWNhSG9zcGl0YWxcIikuYWRkQ2xhc3MoXCJhY3RpdmVcIik7XG4gICAgICAgIH1cbiAgICB9KTtcbn1cblxuZnVuY3Rpb24gaW5pdCgpIHtcbiAgICBpbml0U2xpbXNjcm9sbCgpO1xuICAgIGluaXRNZXRpc01lbnUoKTtcbiAgICBpbml0TGVmdE1lbnVDb2xsYXBzZSgpO1xuICAgIGluaXRFbmxhcmdlKCk7XG4gICAgaW5pdFNlcmFjaCgpO1xuICAgIGluaXRNYWluSWNvbk1lbnUoKTtcbiAgICBpbml0VG9vbHRpcFBsdWdpbigpO1xuICAgIGluaXRBY3RpdmVNZW51KCk7XG4gICAgV2F2ZXMuaW5pdCgpO1xufVxuXG5pbml0KCk7XG5cbiQoXCIuaW5saW5lXCIpLmRhdGVwaWNrZXIoe1xuICAgIHRvZGF5SGlnaGxpZ2h0OiB0cnVlXG59KTtcblxuaWYgKCQoXCIjZGF0YXRhYmxlXCIpLmxlbmd0aCkge1xuICAgICQoXCIjZGF0YXRhYmxlXCIpLkRhdGFUYWJsZSh7XG4gICAgICAgIG9yZGVyOiBbXSxcbiAgICAgICAgbGFuZ3VhZ2U6IHtcbiAgICAgICAgICAgIHVybDpcbiAgICAgICAgICAgICAgICBcIi8vY2RuLmRhdGF0YWJsZXMubmV0L3BsdWctaW5zLzlkY2JlY2Q0MmFkL2kxOG4vUG9ydHVndWVzZS5qc29uXCJcbiAgICAgICAgfVxuICAgIH0pO1xufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/app.js\n");

/***/ }),

/***/ 4:
/*!***********************************!*\
  !*** multi ./resources/js/app.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/diegotauchert/Projects/aquiculturaAPP/resources/js/app.js */"./resources/js/app.js");


/***/ })

/******/ });