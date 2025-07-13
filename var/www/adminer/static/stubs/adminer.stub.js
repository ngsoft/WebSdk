/** Get the first element by selector
 * @param {string} selector
 * @param {HTMLElement} [context] defaults to document
 * @return {HTMLElement|null}
 */
function qs(selector, context) {
}

/** Get last element by selector
 * @param {string} selector
 * @param {HTMLElement} [context] defaults to document
 * @return {HTMLElement|null}
 */
function qsl(selector, context) {
}

/** Get all elements by selector
 * @param {string} selector
 * @param {HTMLElement} [context] defaults to document
 * @return {NodeList}
 */
function qsa(selector, context) {
}

/** Return a function calling fn with the next arguments
 * @param {function} fn
 * @param {...any} args
 * @return {function} function with preserved this
 */
function partial(fn, ...args) {
}

/** Return a function calling fn with the first parameter and then the next arguments
 * @param {function} fn
 * @param {...any} args
 * @return {function} function with preserved this
 */
function partialArg(fn, ...args) {
}

/** Assign values from source to target
 * @param {*} target
 * @param {*} source
 */
function mixin(target, source) {
}

/** Add or remove CSS class
 * @param {HTMLElement} el
 * @param {string} className
 * @param {boolean} [enable]
 */
function alterClass(el, className, enable) {
}

/** Toggle visibility
 * @param {string} id
 * @return boolean false
 */
function toggle(id) {
}

/** Set permanent cookie
 * @param {string} assign
 * @param {number} days
 */
function cookie(assign, days) {
}

/** Verify current Adminer version
 * @param {string} current
 * @param {string} url own URL base
 * @param {string} token
 */
function verifyVersion(current, url, token) {
}

/** Get value of select
 * @param {HTMLSelectElement|HTMLInputElement} select <select> or <input>
 * @return {string}
 */
function selectValue(select) {
}

/** Verify if element has a specified tag name
 * @param {HTMLElement} el
 * @param {string} tag regular expression
 * @return boolean
 */
function isTag(el, tag) {
}

/** Get parent node with specified tag name
 * @param {HTMLElement} el
 * @param {string} tag regular expression
 * @return {HTMLElement}
 */
function parentTag(el, tag) {
}

/** Set checked class
 * @param {HTMLInputElement} el
 */
function trCheck(el) {
}

/** Fill number of selected items
 * @param {string} id
 * @param {string} count
 * @uses thousandsSeparator
 */
function selectCount(id, count) {
}

/** Check all elements matching given name
 * @param {RegExp} name
 * @this HTMLInputElement
 */
function formCheck(name) {
}

/** Check all rows in <table class="checkable">
 */
function tableCheck() {
}

/** Uncheck single element
 * @param {string} id
 */
function formUncheck(id) {
}

/** Get number of checked elements matching given name
 * @param {HTMLInputElement} input
 * @param {RegExp} name
 * @return number
 */
function formChecked(input, name) {
}

/** Select clicked row
 * @param {MouseEvent} event
 * @param {boolean} [click] force click
 */
function tableClick(event, click) {
}


/** Set HTML code of an element
 * @param {string} id
 * @param {string} html undefined to set parentNode to empty string
 */
function setHtml(id, html) {
}

/** Find node position
 * @param {Node} el
 * @return {number}
 */
function nodePosition(el) {
}

/** Go to the specified page
 * @param {string} href
 * @param {string} page
 */
function pageClick(href, page) {
}

/** Hide items in a menu
 * @this HTMLElement
 */
function menuOut() {
}


/** Toggle column context menu
 * @param {string} [className] extra class name
 * @this HTMLElement
 */
function columnMouse(className) {
}


/** Fill column in search field
 * @param {string} name
 * @return boolean false
 */
function selectSearch(name) {
}


/** Check if Ctrl key (Command key on Mac) was pressed
 * @param {KeyboardEvent|MouseEvent} event
 * @return {boolean}
 */
function isCtrl(event) {
}


/** Send form by Ctrl+Enter on <select> and <textarea>
 * @param {KeyboardEvent} event
 * @param {string} [button]
 * @return boolean
 */
function bodyKeydown(event, button) {
}

/** Open form to a new window on Ctrl+click or Shift+click
 * @param {MouseEvent} event
 */
function bodyClick(event) {
}


/** Change focus by Ctrl+Shift+Up or Ctrl+Shift+Down
 * @param {KeyboardEvent} event
 * @return {boolean}
 */
function editingKeydown(event) {
}


/** Skip 'original' when typing
 * @param {number} first
 * @this HTMLTableCellElement
 */
function skipOriginal(first) {
}

/** Add new field in schema-less edit
 * @this HTMLInputElement
 */
function fieldChange() {
}


/** Create AJAX request
 * @param {string} url
 * @param {function(XMLHttpRequest)} callback
 * @param {string} [data]
 * @param {string} [message]
 * @return XMLHttpRequest or false in case of an error
 * @uses offlineMessage
 */
function ajax(url, callback, data, message) {
}

/** Use setHtml(key, value) for JSON response
 * @param {string} url
 * @return boolean false for success
 */
function ajaxSetHtml(url) {
}

let editChanged; // used by plugins

/** Save form contents through AJAX
 * @param {HTMLFormElement} form
 * @param {string} message
 * @param {HTMLInputElement} [button]
 * @return boolean
 */
function ajaxForm(form, message, button) {
}


/** Display edit field
 * @param {MouseEvent} event
 * @param {number} text display textarea instead of input, 2 - load long text
 * @param {string} [warning] warning to display
 * @return {boolean}
 * @this HTMLElement
 */
function selectClick(event, text, warning) {
}


/** Load and display next page in select
 * @param {number} limit
 * @param {string} loading
 * @return {boolean} false for success
 * @this HTMLLinkElement
 */
function selectLoadMore(limit, loading) {
}


/** Stop event propagation
 * @param {Event} event
 */
function eventStop(event) {
}


/** Setup highlighting of default submit button on form field focus
 * @param {HTMLElement} parent
 */
function setupSubmitHighlight(parent) {
}

/** Setup submit highlighting for single element
 * @param {HTMLElement} input
 */
function setupSubmitHighlightInput(input) {
}

/** Highlight default submit button
 * @this HTMLInputElement
 */
function inputFocus() {
}

/** Unhighlight default submit button
 * @this HTMLInputElement
 */
function inputBlur() {
}

/** Find submit button used by Enter
 * @param {HTMLElement} el
 * @return {HTMLInputElement}
 */
function findDefaultSubmit(el) {
}


/** Add event listener
 * @param {HTMLElement} el
 * @param {string} action without 'on'
 * @param {function} handler
 */
function addEvent(el, action, handler) {
}

/** Clone node and setup submit highlighting
 * @param {HTMLElement} el
 * @return {HTMLElement}
 */
function cloneNode(el) {
}

/** Load syntax highlighting
 * @param {string} version first three characters of database system version
 * @param {string} [vendor]
 */
function syntaxHighlighting(version, vendor) {
}


/** Get the value of dynamically created form field
 * @param {HTMLFormElement} form
 * @param {string} name
 * @return {HTMLElement}
 */
function formField(form, name) {
}

/** Try to change input type to password or to text
 * @param {HTMLInputElement} el
 * @param {boolean} disable
 */
function typePassword(el, disable) {
}