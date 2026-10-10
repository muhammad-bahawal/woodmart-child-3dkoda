/**
 * Product Page Builder - Admin Scripts
 * Vanilla JS tab switching, dynamic repeaters, and wp.media uploader
 * Fully compatible with multiple builder meta-boxes (3D Printer & Filament)
 *
 * @package WoodmartChild
 */

document.addEventListener('DOMContentLoaded', function () {
	/* ==========================================================================
	   1. TAB SWITCHING (Delegated & Resilient)
	   ========================================================================== */
	document.addEventListener('click', function (e) {
		const tabBtn = e.target.closest('.wc-tab-btn');
		if (!tabBtn) return;

		e.preventDefault();
		const wrap = tabBtn.closest('.wc-builder-wrap');
		if (!wrap) return;

		const targetTab = tabBtn.getAttribute('data-tab');
		if (!targetTab) return;

		// Toggle buttons in this wrap
		wrap.querySelectorAll('.wc-tab-btn').forEach(btn => {
			btn.classList.toggle('active', btn === tabBtn);
		});

		// Toggle panels in this wrap
		wrap.querySelectorAll('.wc-tab-panel').forEach(panel => {
			panel.classList.toggle('active', panel.id === targetTab);
		});

		try {
			const postbox = wrap.closest('.postbox');
			const postboxId = postbox ? postbox.id : 'wc_builder';
			sessionStorage.setItem('wc_builder_active_tab_' + postboxId, targetTab);
		} catch (err) {}
	});

	// Restore previously active tabs on load for each builder wrap
	document.querySelectorAll('.wc-builder-wrap').forEach(wrap => {
		try {
			const postbox = wrap.closest('.postbox');
			const postboxId = postbox ? postbox.id : 'wc_builder';
			const savedTab = sessionStorage.getItem('wc_builder_active_tab_' + postboxId);

			if (savedTab && wrap.querySelector('#' + savedTab)) {
				wrap.querySelectorAll('.wc-tab-btn').forEach(btn => {
					btn.classList.toggle('active', btn.dataset.tab === savedTab);
				});
				wrap.querySelectorAll('.wc-tab-panel').forEach(panel => {
					panel.classList.toggle('active', panel.id === savedTab);
				});
			}
		} catch (err) {}
	});

	/* ==========================================================================
	   2. DYNAMIC REPEATER ADD & REMOVE (Delegated)
	   ========================================================================== */
	document.addEventListener('click', function (e) {
		// Add row
		const addBtn = e.target.closest('.wc-btn-add-row');
		if (addBtn) {
			e.preventDefault();
			const targetId = addBtn.dataset.target;
			const templateId = addBtn.dataset.template;
			const container = document.getElementById(targetId);
			const tmpl = document.getElementById(templateId);

			if (!container || !tmpl) return;

			const uniqueIndex = Date.now().toString(36) + Math.random().toString(36).substring(2, 5);
			const clone = document.createElement('div');
			clone.innerHTML = tmpl.innerHTML.replace(/{{INDEX}}/g, uniqueIndex).trim();

			const newRow = clone.firstElementChild;
			if (newRow) {
				container.appendChild(newRow);
				const firstInput = newRow.querySelector('input[type="text"], textarea');
				if (firstInput) {
					firstInput.focus();
				}
			}
			return;
		}

		// Remove row
		const removeBtn = e.target.closest('.wc-btn-remove-row');
		if (removeBtn) {
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
			return;
		}
	});

	/* ==========================================================================
	   3. WORDPRESS MEDIA LIBRARY UPLOADER (wp.media)
	   ========================================================================== */
	let mediaFrame = null;
	let activePicker = null;

	document.addEventListener('click', function (e) {
		const uploadBtn = e.target.closest('.wc-btn-upload-image');
		if (uploadBtn) {
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
			return;
		}

		// Remove image
		const removeImgBtn = e.target.closest('.wc-btn-remove-image');
		if (removeImgBtn) {
			e.preventDefault();
			const picker = removeImgBtn.closest('.wc-image-picker');
			if (!picker) return;

			const urlInput = picker.querySelector('.wc-image-url');
			const previewDiv = picker.querySelector('.wc-image-preview');

			if (urlInput) urlInput.value = '';
			if (previewDiv) previewDiv.innerHTML = '';
			removeImgBtn.classList.add('hidden');
			return;
		}
	});

	/* ==========================================================================
	   4. COLOR PICKER SYNC
	   ========================================================================== */
	document.addEventListener('input', function (e) {
		if (e.target.classList.contains('wc-color-picker-input')) {
			const textInput = e.target.closest('.wc-color-field-wrap')?.querySelector('input[type="text"]');
			if (textInput) textInput.value = e.target.value;
		}
	});

	/* ==========================================================================
	   5. DRAG & DROP ROW REORDERING
	   ========================================================================== */
	let draggedRow = null;

	document.addEventListener('dragstart', function (e) {
		const row = e.target.closest('.wc-repeater-row');
		if (!row) return;

		draggedRow = row;
		row.classList.add('is-dragging');
		if (e.dataTransfer) {
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/plain', '');
		}
	});

	document.addEventListener('dragover', function (e) {
		if (!draggedRow) return;
		e.preventDefault();

		if (e.dataTransfer) {
			e.dataTransfer.dropEffect = 'move';
		}

		const targetRow = e.target.closest('.wc-repeater-row');
		if (!targetRow || targetRow === draggedRow) return;

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

	document.addEventListener('dragend', function () {
		if (draggedRow) {
			draggedRow.classList.remove('is-dragging');
			draggedRow = null;
		}
	});

	document.addEventListener('mousedown', function (e) {
		const handle = e.target.closest('.wc-row-drag');
		if (handle) {
			const row = handle.closest('.wc-repeater-row');
			if (row) row.setAttribute('draggable', 'true');
		}
	});

	document.addEventListener('mouseup', function () {
		document.querySelectorAll('.wc-repeater-row[draggable="true"]').forEach(row => {
			row.removeAttribute('draggable');
		});
	});
});
