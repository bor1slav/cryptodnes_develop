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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/charlotte.js":
/*!***********************************!*\
  !*** ./resources/js/charlotte.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var mode = document.getElementById('myonoffswitch');
mode.addEventListener('click', function () {
  var checked = mode.checked;
  var url = mode.dataset.url;
  $.ajaxSetup({
    cache: false,
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    url: url,
    method: 'post',
    data: {
      theme: checked
    },
    success: function success(result) {
      setTimeout(function () {
        location.reload();
      }, 200);
    }
  });
});
window.onload(startTime());

function startTime() {
  var today = new Date();
  var h = today.getHours();
  var m = today.getMinutes();
  var s = today.getSeconds();
  m = checkTime(m);
  s = checkTime(s);
  document.getElementById('curr-time').innerHTML = h + ":" + m + ":" + s;
  var t = setTimeout(startTime, 500);
}

function checkTime(i) {
  if (i < 10) {
    i = "0" + i;
  }

  ; // add zero in front of numbers < 10

  return i;
}

$('#datepicker-inline').datepicker({
  todayHighlight: true
});
$(".counter").counterUp({
  delay: 100,
  time: 1000
}); // maxlength="200" <- TOVA SE DOBAVQ V HTMLA na inputa kato attribute inache ne baca

$(document).ready(function () {
  $('[live-count]').each(function (i, el) {
    //if type is edior skip
    if (el.classList.value === 'description') {
      return true;
    }

    var input = $(el);
    var value_count = el.value.length;
    var max_chars = input.attr('live-count');
    var rand_id = Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
    var span_box = "<span  id=" + rand_id + " class=\"m-l-5 max_char\">(" + value_count + "/" + max_chars + ")</span></label>";
    var parent_html = $(input).parents()[1];
    var parent = $(parent_html);
    var label_html = parent.children()[0];
    var label = $(label_html);
    label.html(label.html() + span_box);
    input.bind("change keyup input paste", function () {
      var len;
      var change_span = $('#' + rand_id);
      len = this.value.length;

      if (len > max_chars) {
        change_span.html("(" + len + "/" + max_chars + ")");
        change_span.addClass('text-danger');
      } else if (len > 0) {
        change_span.html("(" + len + "/" + max_chars + ")");
        change_span.removeClass('text-danger');
      } else {
        change_span.html("(0/" + max_chars + ")");
        change_span.removeClass('text-danger');
      }
    });
  });
});

/***/ }),

/***/ 2:
/*!*****************************************!*\
  !*** multi ./resources/js/charlotte.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\administration\resources\js\charlotte.js */"./resources/js/charlotte.js");


/***/ })

/******/ });