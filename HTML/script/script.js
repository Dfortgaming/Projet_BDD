document.addEventListener("DOMContentLoaded", () => {
    const menuToggle = document.getElementById("menu-toggle");
    const pages = document.getElementById("pages");

    if (menuToggle && pages) {
        menuToggle.addEventListener("click", () => {
            const isOpen = pages.classList.toggle("is-open");

            menuToggle.setAttribute("aria-expanded", isOpen);
            menuToggle.setAttribute(
                "aria-label",
                isOpen ? "Fermer le menu" : "Ouvrir le menu"
            );

            menuToggle.textContent = isOpen ? "✕" : "☰";
        });

        pages.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                pages.classList.remove("is-open");
                menuToggle.setAttribute("aria-expanded", "false");
                menuToggle.setAttribute("aria-label", "Ouvrir le menu");
                menuToggle.textContent = "☰";
            });
        });
    }

    // Gestion de la fenêtre déroulante "Mon compte"
    const accountBtn = document.getElementById("account-btn");
    const accountDropdown = document.getElementById("account-dropdown");

    if (accountBtn && accountDropdown) {
        accountBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isOpen = accountDropdown.classList.toggle("is-open");
            accountBtn.setAttribute("aria-expanded", isOpen);
        });

        document.addEventListener("click", (e) => {
            if (!accountDropdown.contains(e.target) && !accountBtn.contains(e.target)) {
                accountDropdown.classList.remove("is-open");
                accountBtn.setAttribute("aria-expanded", "false");
            }
        });
    }

    // Fermeture des menus avec la touche Échap
    document.addEventListener("keydown", event => {
        if (event.key === "Escape") {
            if (pages && menuToggle) {
                pages.classList.remove("is-open");
                menuToggle.setAttribute("aria-expanded", "false");
                menuToggle.setAttribute("aria-label", "Ouvrir le menu");
                menuToggle.textContent = "☰";
            }
            if (accountDropdown && accountBtn) {
                accountDropdown.classList.remove("is-open");
                accountBtn.setAttribute("aria-expanded", "false");
            }
        }
    });
});