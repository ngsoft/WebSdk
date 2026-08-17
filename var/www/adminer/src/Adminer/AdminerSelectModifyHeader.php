<?php

namespace Adminer;

/** Restore the Modify link in the header of the select result table, moved to a fieldset in Adminer 6.0.0. */
class AdminerSelectModifyHeader
{
    public function head($dark = null)
    {
        if ( ! isset($_GET['select']))
        {
            return;
        }
        echo script("addEventListener('DOMContentLoaded', () => {
    const save = qs('#save');
    const check = qs('#all-page');
    const link = save && save.closest('fieldset').querySelector('legend a');
    if (!link || !check) {
        return;
    }
    // same order as in the rows below: the link, then the checkbox
    check.before(link.cloneNode(true), ' ');
    // designs style the links in thead differently (e.g. color: inherit) in both the normal and the hover state
    const rowLink = qs('#table tbody td.check a');
    if (!rowLink) {
        return;
    }
    // the hover declarations are copied as written so that the CSS variables of the design keep working
    let hover = '';
    for (const sheet of document.styleSheets) {
        let rules;
        try {
            rules = sheet.cssRules;
        } catch (e) {
            continue; // stylesheet from another origin
        }
        for (const rule of rules) {
            if (rule.style && (rule.selectorText || '').split(',').some(part => /^a(:[\\w-]+)*:hover$/.test(part.trim()))) {
                hover = rule.style.cssText;
            }
        }
    }
    const color = getComputedStyle(rowLink).color;
    const style = document.createElement('style');
    style.textContent = '#table thead td.check a { color: ' + color + '; }'
        + '#table thead td.check a:hover { ' + (hover || 'color: ' + color) + ' }';
    document.head.append(style);
});");
    }
}
