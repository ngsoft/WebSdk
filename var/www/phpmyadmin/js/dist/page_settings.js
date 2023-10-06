function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
/**
 * @fileoverview    function used for page-related settings
 * @name            Page-related settings
 *
 * @requires    jQuery
 * @requires    jQueryUI
 * @required    js/functions.js
 */

function showSettings(selector) {
  var _buttons;
  var buttons = (_buttons = {}, _defineProperty(_buttons, Messages.strApply, {
    text: Messages.strApply,
    "class": 'btn btn-primary'
  }), _defineProperty(_buttons, Messages.strCancel, {
    text: Messages.strCancel,
    "class": 'btn btn-secondary'
  }), _buttons);
  buttons[Messages.strApply].click = function () {
    $('.config-form').trigger('submit');
  };
  buttons[Messages.strCancel].click = function () {
    $(this).dialog('close');
  };

  // Keeping a clone to restore in case the user cancels the operation
  var $clone = $(selector + ' .page_settings').clone(true);
  $(selector).dialog({
    classes: {
      'ui-dialog-titlebar-close': 'btn-close'
    },
    title: Messages.strPageSettings,
    width: 700,
    minHeight: 250,
    modal: true,
    open: function open() {
      $(this).dialog('option', 'maxHeight', $(window).height() - $(this).offset().top);
    },
    close: function close() {
      $(selector + ' .page_settings').replaceWith($clone);
    },
    buttons: buttons
  });
}
function showPageSettings() {
  showSettings('#page_settings_modal');
}
function showNaviSettings() {
  showSettings('#pma_navigation_settings');
}
AJAX.registerTeardown('page_settings.js', function () {
  $('#page_settings_icon').css('display', 'none');
  $('#page_settings_icon').off('click');
  $('#pma_navigation_settings_icon').off('click');
});
AJAX.registerOnload('page_settings.js', function () {
  if ($('#page_settings_modal').length) {
    $('#page_settings_icon').css('display', 'inline');
    $('#page_settings_icon').on('click', showPageSettings);
  }
  $('#pma_navigation_settings_icon').on('click', showNaviSettings);
});