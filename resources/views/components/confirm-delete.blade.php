<div id="confirmDeleteModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4" role="dialog" aria-modal="true" aria-labelledby="confirmDeleteTitle">
    <div id="confirmDeleteBackdrop" class="confirm-delete-backdrop absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div id="confirmDeletePanel" class="avatar-modal relative w-full max-w-md rounded-3xl shadow-2xl p-6">
        <div class="flex items-start gap-3">
            <div class="avatar-modal-icon flex-none w-11 h-11 rounded-full flex items-center justify-center"><i id="confirmDeleteIcon" class="fa-solid fa-trash-can"></i></div>
            <div class="flex-1 min-w-0 pt-0.5">
                <h3 id="confirmDeleteTitle" class="avatar-modal-title font-extrabold">{{ __('Hapus') }}</h3>
                <p id="confirmDeleteText" class="avatar-modal-text mt-1 text-sm">{{ __('Apakah Anda yakin ingin menghapus?') }}</p>
            </div>
        </div>
        <div class="mt-6 flex flex-col-reverse sm:flex-row gap-2 sm:justify-end">
            <button type="button" id="confirmDeleteCancel" class="avatar-modal-btn-neutral px-5 py-2.5 rounded-full text-sm font-bold transition">{{ __('Batal') }}</button>
            <form id="confirmDeleteForm" method="POST" action="#">
                @csrf
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" id="confirmDeleteSubmit" class="w-full px-5 py-2.5 rounded-full text-sm font-bold text-white transition bg-red-600 hover:bg-red-700">{{ __('Ya, Hapus') }}</button>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    var modal = document.getElementById('confirmDeleteModal');
    if (! modal) return;
    var backdrop = document.getElementById('confirmDeleteBackdrop');
    var titleEl = document.getElementById('confirmDeleteTitle');
    var textEl = document.getElementById('confirmDeleteText');
    var iconEl = document.getElementById('confirmDeleteIcon');
    var form = document.getElementById('confirmDeleteForm');
    var submitBtn = document.getElementById('confirmDeleteSubmit');
    var cancelBtn = document.getElementById('confirmDeleteCancel');

    function show() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function hide() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    function open(cfg) {
        cfg = cfg || {};
        titleEl.textContent = cfg.title || '{{ __('Hapus') }}';
        textEl.textContent = cfg.message || '';
        iconEl.className = cfg.icon || 'fa-solid fa-trash-can';
        form.setAttribute('action', cfg.action || '#');
        var hidden = form.querySelector('input[name="_method"]');
        if (hidden) hidden.value = cfg.method || 'DELETE';
        submitBtn.className = 'w-full px-5 py-2.5 rounded-full text-sm font-bold text-white transition ' + (cfg.submitClass || 'bg-red-600 hover:bg-red-700');
        submitBtn.textContent = cfg.submitLabel || '{{ __('Ya, Hapus') }}';
        cancelBtn.textContent = cfg.cancelLabel || '{{ __('Batal') }}';
        show();
    }
    window.confirmDelete = open;
    window.closeConfirmDelete = hide;
    backdrop.addEventListener('click', hide);
    cancelBtn.addEventListener('click', hide);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') hide(); });
})();
</script>
