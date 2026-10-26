(function () {
    var body = document.body;
    var reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    var sidebar = document.querySelector(".sidebar");
    var toggle = document.querySelector("[data-nav-toggle]");
    var backdrop = document.querySelector("[data-nav-backdrop]");
    var accountToggle = document.querySelector("[data-account-toggle]");
    var accountMenu = document.querySelector("[data-account-menu]");

    function setNav(open) {
        if (!sidebar) return;
        sidebar.classList.toggle("is-open", open);
        body.classList.toggle("nav-open", open);
        if (backdrop) backdrop.hidden = !open;
        if (toggle) toggle.setAttribute("aria-expanded", open ? "true" : "false");
    }

    function setAccount(open) {
        if (!accountMenu || !accountToggle) return;
        accountMenu.hidden = !open;
        accountToggle.setAttribute("aria-expanded", open ? "true" : "false");
    }

    if (toggle) {
        toggle.addEventListener("click", function () {
            setNav(!sidebar.classList.contains("is-open"));
        });
    }
    if (backdrop) {
        backdrop.addEventListener("click", function () { setNav(false); });
    }
    if (accountToggle) {
        accountToggle.addEventListener("click", function (event) {
            event.stopPropagation();
            setAccount(accountMenu.hidden);
        });
    }
    document.addEventListener("click", function (event) {
        if (!accountMenu || accountMenu.hidden) return;
        if (!event.target.closest(".account")) setAccount(false);
    });

    var grid = document.querySelector("[data-catalog-grid]");
    if (grid) {
        var cards = Array.prototype.slice.call(grid.querySelectorAll(".product-card"));
        var empty = document.querySelector("[data-catalog-empty]");
        var count = document.querySelector("[data-catalog-count]");
        var queryLabel = document.querySelector("[data-catalog-query]");
        var chips = Array.prototype.slice.call(document.querySelectorAll("[data-filter]"));
        var sort = document.querySelector("[data-sort]");
        var search = document.querySelector("#query");
        var form = document.querySelector("#form");
        var query = (body.getAttribute("data-q") || "").trim();
        var cat = body.getAttribute("data-cat") || "all";

        function norm(value) {
            return (value || "").toLowerCase();
        }

        function apply() {
            var q = norm(query);
            cards.forEach(function (card) {
                var hay = norm(card.getAttribute("data-name") + " " + card.getAttribute("data-description") + " " + card.getAttribute("data-category"));
                var okCat = cat === "all" || cat === "" || card.getAttribute("data-category-id") === cat;
                var show = okCat && (!q || hay.indexOf(q) !== -1);
                if (show) card.removeAttribute("hidden");
                else card.setAttribute("hidden", "");
            });

            if (sort) {
                var mode = sort.value;
                cards.slice().sort(function (a, b) {
                    if (mode === "price-asc") return Number(a.getAttribute("data-price")) - Number(b.getAttribute("data-price"));
                    if (mode === "price-desc") return Number(b.getAttribute("data-price")) - Number(a.getAttribute("data-price"));
                    if (mode === "name") return a.getAttribute("data-name").localeCompare(b.getAttribute("data-name"), "es");
                    return Number(b.getAttribute("data-id")) - Number(a.getAttribute("data-id"));
                }).forEach(function (card) {
                    grid.appendChild(card);
                });
            }

            var visible = cards.filter(function (card) { return !card.hasAttribute("hidden"); }).length;
            if (count) count.textContent = visible + (visible === 1 ? " producto" : " productos");
            if (queryLabel) queryLabel.textContent = query ? "Resultados para “" + query + "”" : "Todo el catálogo";
            if (empty) empty.hidden = visible !== 0;
            chips.forEach(function (chip) {
                chip.classList.toggle("is-active", chip.getAttribute("data-filter") === (cat || "all"));
            });
        }

        chips.forEach(function (chip) {
            chip.addEventListener("click", function () {
                cat = chip.getAttribute("data-filter");
                var url = new URL(window.location.href);
                if (cat === "all") url.searchParams.delete("cat");
                else url.searchParams.set("cat", cat);
                history.replaceState({}, "", url);
                apply();
            });
        });

        if (sort) sort.addEventListener("change", apply);

        function syncQuery(next, push) {
            query = (next || "").trim();
            var url = new URL(window.location.href);
            if (query) url.searchParams.set("q", query);
            else url.searchParams.delete("q");
            if (push) history.replaceState({}, "", url);
            apply();
        }

        if (search) {
            search.addEventListener("input", function () { syncQuery(search.value, true); });
        }
        if (form) {
            form.addEventListener("submit", function (event) {
                event.preventDefault();
                syncQuery(search ? search.value : "", true);
            });
        }

        var reset = document.querySelector("[data-reset-filters]");
        if (reset) {
            reset.addEventListener("click", function () {
                cat = "all";
                query = "";
                if (search) search.value = "";
                if (sort) sort.value = "recent";
                history.replaceState({}, "", window.location.pathname);
                apply();
            });
        }

        window.addEventListener("popstate", function () {
            var params = new URLSearchParams(window.location.search);
            query = (params.get("q") || "").trim();
            cat = params.get("cat") || "all";
            if (search) search.value = query;
            apply();
        });

        apply();
    }

    document.addEventListener("click", function (event) {
        var btn = event.target.closest("[data-qty]");
        if (!btn) return;
        var wrap = btn.closest(".qty");
        var input = wrap ? wrap.querySelector('input[name="cantidad"]') : null;
        if (!input || input.disabled) return;
        var max = Number(input.max || 99);
        var min = Number(input.min || 1);
        var next = Math.min(max, Math.max(min, (Number(input.value) || 1) + Number(btn.getAttribute("data-qty"))));
        input.value = String(next);
    });

    var modal = document.querySelector("#addProductModal");

    function closeModal() {
        if (!modal || modal.hidden) return;
        modal.hidden = true;
        body.classList.remove("modal-open");
    }

    function openModal() {
        if (!modal) return;
        modal.hidden = false;
        body.classList.add("modal-open");
        var field = modal.querySelector("input, textarea, select");
        if (field) field.focus();
    }

    var opener = document.querySelector("[data-open-modal]");
    if (opener) opener.addEventListener("click", openModal);
    if (modal) {
        modal.addEventListener("click", function (event) {
            if (event.target === modal || event.target.closest("[data-close-modal]")) closeModal();
        });
    }

    document.addEventListener("keydown", function (event) {
        if (event.key !== "Escape") return;
        setNav(false);
        setAccount(false);
        closeModal();
    });

    var hero = document.querySelector("[data-hero]");
    if (hero) {
        var slides = Array.prototype.slice.call(hero.querySelectorAll("[data-slide]"));
        var dots = Array.prototype.slice.call(hero.querySelectorAll("[data-dot]"));
        var index = 0;
        var timer = null;

        function go(next) {
            index = (next + slides.length) % slides.length;
            slides.forEach(function (slide, i) {
                var on = i === index;
                slide.classList.toggle("is-active", on);
                slide.setAttribute("aria-hidden", on ? "false" : "true");
            });
            dots.forEach(function (dot, i) {
                var on = i === index;
                dot.classList.toggle("is-active", on);
                dot.setAttribute("aria-selected", on ? "true" : "false");
            });
        }

        function play() {
            stop();
            if (reduced || slides.length < 2) return;
            timer = window.setInterval(function () { go(index + 1); }, 5600);
        }

        function stop() {
            if (timer) window.clearInterval(timer);
            timer = null;
        }

        var prev = hero.querySelector("[data-hero-prev]");
        var nextBtn = hero.querySelector("[data-hero-next]");
        if (prev) prev.addEventListener("click", function () { go(index - 1); play(); });
        if (nextBtn) nextBtn.addEventListener("click", function () { go(index + 1); play(); });
        dots.forEach(function (dot) {
            dot.addEventListener("click", function () {
                go(Number(dot.getAttribute("data-dot")));
                play();
            });
        });
        hero.addEventListener("mouseenter", stop);
        hero.addEventListener("mouseleave", play);
        hero.addEventListener("focusin", stop);
        hero.addEventListener("focusout", play);
        play();
    }

    var toast = document.querySelector(".toast-note");
    if (toast && !reduced) {
        window.setTimeout(function () { toast.classList.add("is-out"); }, 3200);
    }

    Array.prototype.forEach.call(document.querySelectorAll(".product-media img"), function (img) {
        img.addEventListener("error", function () { img.remove(); });
    });

    var cartCount = document.querySelector("#cart-count");
    if (cartCount) {
        fetch("obtener_cantidad_carrito.php")
            .then(function (response) { return response.text(); })
            .then(function (text) {
                var n = text.trim();
                cartCount.textContent = n;
                cartCount.hidden = n === "" || n === "0";
            })
            .catch(function () {});
    }
})();
