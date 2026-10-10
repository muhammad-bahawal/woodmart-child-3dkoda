/**
 * Product Page Builder - Admin Scripts
 * Vanilla JS tab switching, dynamic repeaters, and wp.media uploader
 *
 * @package WoodmartChild
 */

document.addEventListener('DOMContentLoaded', function () {
	const wrap = document.querySelector('.wc-builder-wrap');
	if (!wrap) return;

	/* ==========================================================================
	   1. TAB SWITCHING
	   ========================================================================== */
	const tabButtons = wrap.querySelectorAll('.wc-tab-btn');
	const tabPanels = wrap.querySelectorAll('.wc-tab-panel');
	const STORAGE_KEY = 'wc_builder_active_tab';

	function activateTab(tabId) {
		tabButtons.forEach(btn => {
			btn.classList.toggle('active', btn.dataset.tab === tabId);
		});

		tabPanels.forEach(panel => {
			panel.classList.toggle('active', panel.id === tabId);
		});

		try {
			sessionStorage.setItem(STORAGE_KEY, tabId);
		} catch (e) {
			// Ignore storage access errors
		}
	}

	tabButtons.forEach(btn => {
		btn.addEventListener('click', function () {
			activateTab(this.dataset.tab);
		});
	});

	// Restore previously active tab if available
	try {
		const savedTab = sessionStorage.getItem(STORAGE_KEY);
		if (savedTab && wrap.querySelector('#' + savedTab)) {
			activateTab(savedTab);
		}
	} catch (e) {}

	/* ==========================================================================
	   2. DYNAMIC REPEATER ADD & REMOVE
	   ========================================================================== */
	wrap.querySelectorAll('.wc-btn-add-row').forEach(addBtn => {
		addBtn.addEventListener('click', function () {
			const targetId = this.dataset.target;
			const templateId = this.dataset.template;
			const container = document.getElementById(targetId);
			const tmpl = document.getElementById(templateId);

			if (!container || !tmpl) return;

			const uniqueIndex = Date.now().toString(36) + Math.random().toString(36).substring(2, 5);
			const clone = document.createElement('div');
			clone.innerHTML = tmpl.innerHTML.replace(/{{INDEX}}/g, uniqueIndex).trim();

			const newRow = clone.firstElementChild;
			if (newRow) {
				container.appendChild(newRow);
				// Focus the first input of the newly added row
				const firstInput = newRow.querySelector('input[type="text"], textarea');
				if (firstInput) {
					firstInput.focus();
				}
			}
		});
	});

	// Event delegation for row removal
	wrap.addEventListener('click', function (e) {
		const removeBtn = e.target.closest('.wc-btn-remove-row');
		if (!removeBtn) return;

		e.preventDefault();
		const row = removeBtn.closest('.wc-repeater-row');
		if (row) {
			row.style.transition = 'all 0.2s ease';
			row.style.opacity = '0';
			row.style.transform = 'scale(0.95)';
			setTimeout(() => {
				row.remove();
			}, 200);
		}
	});

	/* ==========================================================================
	   3. WORDPRESS MEDIA LIBRARY UPLOADER (wp.media)
	   ========================================================================== */
	let mediaFrame = null;
	let activePicker = null;

	wrap.addEventListener('click', function (e) {
		const uploadBtn = e.target.closest('.wc-btn-upload-image');
		if (!uploadBtn) return;

		e.preventDefault();
		activePicker = uploadBtn.closest('.wc-image-picker');
		if (!activePicker) return;

		if (typeof wp === 'undefined' || !wp.media) {
			alert('WordPress Media Library is not available.');
			return;
		}

		if (mediaFrame) {
			mediaFrame.open();
			return;
		}

		// Create reusable wp.media frame
		mediaFrame = wp.media({
			title: 'Select or Upload Product Image',
			button: {
				text: 'Use this image'
			},
			multiple: false,
			library: {
				type: 'image'
			}
		});

		mediaFrame.on('select', function () {
			if (!activePicker) return;

			const attachment = mediaFrame.state().get('selection').first().toJSON();
			if (attachment && attachment.url) {
				const urlInput = activePicker.querySelector('.wc-image-url');
				const previewDiv = activePicker.querySelector('.wc-image-preview');
				const removeBtn = activePicker.querySelector('.wc-btn-remove-image');

				if (urlInput) urlInput.value = attachment.url;
				if (previewDiv) previewDiv.innerHTML = `<img src="${attachment.url}" alt="">`;
				if (removeBtn) removeBtn.classList.remove('hidden');
			}
		});

		mediaFrame.open();
	});

	// Remove image
	wrap.addEventListener('click', function (e) {
		const removeBtn = e.target.closest('.wc-btn-remove-image');
		if (!removeBtn) return;

		e.preventDefault();
		const picker = removeBtn.closest('.wc-image-picker');
		if (!picker) return;

		const urlInput = picker.querySelector('.wc-image-url');
		const previewDiv = picker.querySelector('.wc-image-preview');

		if (urlInput) urlInput.value = '';
		if (previewDiv) previewDiv.innerHTML = '';
		removeBtn.classList.add('hidden');
	});

	/* ==========================================================================
	   4. COLOR PICKER SYNC
	   ========================================================================== */
	wrap.addEventListener('input', function (e) {
		if (e.target.classList.contains('wc-color-picker-input')) {
			const textInput = e.target.closest('.wc-color-field-wrap')?.querySelector('input[type="text"]');
			if (textInput) textInput.value = e.target.value;
		}
	});

	/* ==========================================================================
	   5. DRAG & DROP ROW REORDERING
	   ========================================================================== */
	let draggedRow = null;

	wrap.addEventListener('dragstart', function (e) {
		const row = e.target.closest('.wc-repeater-row');
		if (!row) return;

		draggedRow = row;
		row.classList.add('is-dragging');
		if (e.dataTransfer) {
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', '');
		}
	});

	wrap.addEventListener('dragover', function (e) {
		if (!draggedRow) return;
		e.preventDefault();

		if (e.dataTransfer) {
			e.dataTransfer.dropEffect = 'move';
		}

		const targetRow = e.target.closest('.wc-repeater-row');
		if (!targetRow || targetRow === draggedRow) return;

		// Only reorder within the same repeater container
		if (targetRow.parentElement !== draggedRow.parentElement) return;

		const container = targetRow.parentElement;
		const rect = targetRow.getBoundingClientRect();
		const midY = rect.top + rect.height / 2;

		if (e.clientY < midY) {
			container.insertBefore(draggedRow, targetRow);
		} else {
			container.insertBefore(draggedRow, targetRow.nextSibling);
		}
	});

	wrap.addEventListener('dragend', function () {
		if (draggedRow) {
			draggedRow.classList.remove('is-dragging');
			draggedRow = null;
		}
	});

	wrap.addEventListener('mousedown', function (e) {
		const handle = e.target.closest('.wc-row-drag');
		if (handle) {
			const row = handle.closest('.wc-repeater-row');
			if (row) row.setAttribute('draggable', 'true');
		}
	});

	wrap.addEventListener('mouseup', function () {
		wrap.querySelectorAll('.wc-repeater-row[draggable="true"]').forEach(row => {
			row.removeAttribute('draggable');
		});
	});
});
