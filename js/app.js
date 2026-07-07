/**
 * ============================================================================
 * MEPSC - Manipuri-English Parallel Speech Corpus
 * ============================================================================
 * File: js/app.js
 *
 * Description:
 * Shared JavaScript utilities used by the public and admin portals.
 *
 * Technology:
 * - Vanilla JavaScript
 * ============================================================================
 */

'use strict';

/**
 * --------------------------------------------------------------------------
 * Escape HTML to prevent XSS when inserting text into the DOM.
 * --------------------------------------------------------------------------
 *
 * @param {string} text
 * @returns {string}
 */
function escapeHtml(text) {

    const div = document.createElement('div');

    div.textContent = text ?? '';

    return div.innerHTML;
}

/**
 * --------------------------------------------------------------------------
 * Show an element.
 * --------------------------------------------------------------------------
 *
 * @param {string} id
 */
function showElement(id) {

    const element = document.getElementById(id);

    if (element) {
        element.style.display = '';
    }
}

/**
 * --------------------------------------------------------------------------
 * Hide an element.
 * --------------------------------------------------------------------------
 *
 * @param {string} id
 */
function hideElement(id) {

    const element = document.getElementById(id);

    if (element) {
        element.style.display = 'none';
    }
}

/**
 * --------------------------------------------------------------------------
 * Display a Bootstrap alert inside a container.
 * --------------------------------------------------------------------------
 *
 * @param {string} containerId
 * @param {string} message
 * @param {string} type
 */
function showAlert(containerId, message, type = 'success') {

    const container = document.getElementById(containerId);

    if (!container) {
        return;
    }

    container.innerHTML =
        '<div class="alert alert-' + type + '">' +
            escapeHtml(message) +
        '</div>';
}

/**
 * --------------------------------------------------------------------------
 * Clear a Bootstrap alert container.
 * --------------------------------------------------------------------------
 *
 * @param {string} containerId
 */
function clearAlert(containerId) {

    const container = document.getElementById(containerId);

    if (container) {
        container.innerHTML = '';
    }
}

/**
 * --------------------------------------------------------------------------
 * POST FormData using Fetch API.
 * --------------------------------------------------------------------------
 *
 * @param {string} url
 * @param {FormData} formData
 * @returns {Promise<Object>}
 */
async function postForm(url, formData) {

    const response = await fetch(url, {
        method: 'POST',
        body: formData
    });

    return await response.json();
}

/**
 * --------------------------------------------------------------------------
 * GET JSON using Fetch API.
 * --------------------------------------------------------------------------
 *
 * @param {string} url
 * @returns {Promise<Object>}
 */
async function getJson(url) {

    const response = await fetch(url);

    return await response.json();
}

/**
 * --------------------------------------------------------------------------
 * Debounce helper.
 * --------------------------------------------------------------------------
 *
 * @param {Function} callback
 * @param {number} delay
 * @returns {Function}
 */
function debounce(callback, delay = 300) {

    let timer = null;

    return function (...args) {

        clearTimeout(timer);

        timer = setTimeout(() => {
            callback.apply(this, args);
        }, delay);

    };
}

/**
 * --------------------------------------------------------------------------
 * Confirm before deleting a sentence.
 * --------------------------------------------------------------------------
 *
 * @returns {boolean}
 */
function confirmDelete() {

    return window.confirm(
        'Are you sure you want to delete this sentence?'
    );
}