// document.querySelectorAll('.js-calendar-date').forEach(el => {
//     el.addEventListener('click', () => {
//         const date = el.dataset.date;
//         const params = new URLSearchParams(window.location.search);
//         params.set('selected', date);
//         window.location.search = params.toString();
//     });
// });

    function handleJournalClick(date, hasJournal) {
        const url = new URL(window.location.href);
        url.searchParams.set('month', '{{ $month }}');
        url.searchParams.set('year', '{{ $year }}');
        url.searchParams.set('selected', date);
        history.pushState({}, '', url); // Ubah URL tanpa reload

        // Trigger buka modal
        const modalName = hasJournal ? 'view-journal' : 'create-journal';
        window.dispatchEvent(new CustomEvent('open-modal', {
            detail: modalName
        }));
    }