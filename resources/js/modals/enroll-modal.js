// Enroll Modal Logic
document.addEventListener("DOMContentLoaded", function () {
    const openBtn = document.getElementById("openEnrollModalBtn");
    const modal = document.getElementById("enrollResidentModal");
    const closeButtons = modal?.querySelectorAll("[data-modal-hide]");

    openBtn?.addEventListener("click", () => {
        modal?.classList.remove("hidden");
    });

    closeButtons?.forEach(btn => {
        btn.addEventListener("click", () => {
            modal?.classList.add("hidden");
        });
    });

    modal?.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.add("hidden");
        }
    });
});
