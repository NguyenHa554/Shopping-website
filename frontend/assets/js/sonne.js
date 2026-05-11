/**
 * SONNE – Global Client-Side JS
 * Handles: cart badge, cart AJAX, toast notifications, countdown timer,
 *          nav scroll, mobile menu, user dropdown, guest cart (localStorage)
 */
(function () {
    'use strict';

    // ── Helper: Toast notification ────────────────────────────────
    window.showToast = function (message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `<span>${message}</span><button onclick="this.parentElement.remove()"><i class="fa fa-times"></i></button>`;
        let container = document.getElementById('toastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        container.appendChild(toast);
        setTimeout(() => { toast.classList.add('toast-show'); }, 50);
        setTimeout(() => { toast.classList.remove('toast-show'); setTimeout(() => toast.remove(), 300); }, 3500);
    };

    // ── Cart count badge ──────────────────────────────────────────
    function updateCartBadge(count) {
        const badge = document.getElementById('cartCount');
        if (badge) badge.textContent = count;
    }

    // Fetch cart count from server (logged-in users)
    function fetchCartCount() {
        if (!IS_LOGGED_IN) {
            // Guest: count from localStorage
            const cart = getGuestCart();
            const count = cart.reduce((s, i) => s + (i.quantity || 1), 0);
            updateCartBadge(count);
            return;
        }
        fetch(BASE_URL + '/cart/count')
            .then(r => r.json())
            .then(d => updateCartBadge(d.count || 0))
            .catch(() => { });
    }

    // ── Guest Cart (localStorage) ─────────────────────────────────
    function getGuestCart() {
        try { return JSON.parse(localStorage.getItem('sonne_cart') || '[]'); }
        catch (e) { return []; }
    }
    function saveGuestCart(cart) {
        localStorage.setItem('sonne_cart', JSON.stringify(cart));
    }
    function addToGuestCart(id, name, price, img, qty = 1) {
        const cart = getGuestCart();
        const idx = cart.findIndex(i => i.id === id);
        if (idx > -1) cart[idx].quantity += qty;
        else cart.push({ id, name, price, img, quantity: qty });
        saveGuestCart(cart);
        fetchCartCount();
        showToast('Đã thêm vào giỏ hàng!', 'success');
    }

    // After login, sync guest cart to server
    function syncGuestCartOnLogin() {
        if (!IS_LOGGED_IN) return;
        const cart = getGuestCart();
        if (!cart.length) return;
        fetch(BASE_URL + '/cart/sync', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'cart=' + encodeURIComponent(JSON.stringify(cart)) + '&csrf_token=' + encodeURIComponent(CSRF_TOKEN)
        }).then(r => r.json()).then(d => {
            if (d.status === 'ok') {
                localStorage.removeItem('sonne_cart');
                updateCartBadge(d.count);
            }
        }).catch(() => { });
    }

    // ── Add to Cart (product cards & lists) ──────────────────────
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-add-cart');
        if (!btn || btn.disabled) return;
        e.preventDefault();
        const id = parseInt(btn.dataset.id);
        const name = btn.dataset.name || '';
        const price = parseFloat(btn.dataset.price) || 0;
        const img = btn.dataset.img || '';

        if (!IS_LOGGED_IN) {
            addToGuestCart(id, name, price, img, 1);
            return;
        }

        fetch(BASE_URL + '/cart/add', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${id}&quantity=1&csrf_token=${encodeURIComponent(CSRF_TOKEN)}`
        }).then(r => r.json()).then(d => {
            if (d.count !== undefined) updateCartBadge(d.count);
            if (d.error) showToast(d.error, 'error');
            else showToast('Đã thêm vào giỏ hàng!', 'success');
        }).catch(() => showToast('Lỗi kết nối.', 'error'));
    });

    // ── Cart page: update / remove ────────────────────────────────
    function bindCartActions() {
        // Quantity change
        document.querySelectorAll('.cart-qty-inc').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.querySelector(`.cart-qty-input[data-id="${btn.dataset.id}"]`);
                if (!input) return;
                input.value = parseInt(input.value) + 1;
                updateCartItemQty(btn.dataset.id, parseInt(input.value));
            });
        });
        document.querySelectorAll('.cart-qty-dec').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.querySelector(`.cart-qty-input[data-id="${btn.dataset.id}"]`);
                if (!input) return;
                const newVal = Math.max(1, parseInt(input.value) - 1);
                input.value = newVal;
                updateCartItemQty(btn.dataset.id, newVal);
            });
        });
        // Remove
        document.querySelectorAll('.cart-item-remove').forEach(btn => {
            btn.addEventListener('click', () => removeCartItem(btn.dataset.id));
        });
    }

    function updateCartItemQty(pid, qty) {
        if (!IS_LOGGED_IN) return;
        fetch(BASE_URL + '/cart/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${pid}&quantity=${qty}&csrf_token=${encodeURIComponent(CSRF_TOKEN)}`
        }).then(r => r.json()).then(d => {
            if (d.count !== undefined) updateCartBadge(d.count);
            recalcCartSummary();
        }).catch(() => { });
    }

    function removeCartItem(pid) {
        if (!IS_LOGGED_IN) return;
        fetch(BASE_URL + '/cart/remove', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `product_id=${pid}&csrf_token=${encodeURIComponent(CSRF_TOKEN)}`
        }).then(r => r.json()).then(d => {
            if (d.count !== undefined) updateCartBadge(d.count);
            const item = document.querySelector(`.cart-item[data-id="${pid}"]`);
            if (item) item.remove();
            recalcCartSummary();
            if (!document.querySelector('.cart-item')) {
                const panel = document.getElementById('cartMainPanel');
                if (panel) panel.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon"><i class="fa fa-shopping-bag"></i></div>
                    <h2>Giỏ hàng trống</h2>
                    <p>Hãy thêm sản phẩm vào giỏ hàng!</p>
                    <a href="${BASE_URL}/products" class="btn btn-primary">Mua sắm ngay</a>
                </div>`;
            }
        }).catch(() => { });
    }

    function recalcCartSummary() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            const qty = parseInt(item.querySelector('.cart-qty-input')?.value || 0);
            const priceEl = item.querySelector('.cart-item-price');
            const price = priceEl ? parseFloat(priceEl.textContent.replace(/[^\d]/g, '')) : 0;
            const sub = qty * price;
            const subEl = item.querySelector('.cart-item-subtotal');
            if (subEl) subEl.textContent = sub.toLocaleString('vi-VN') + ' ₫';
            subtotal += sub;
        });
        const shipping = subtotal >= 500000 ? 0 : 30000;
        const total = subtotal + shipping;
        const fmt = v => v.toLocaleString('vi-VN') + ' ₫';
        const subEl = document.getElementById('summarySubtotal');
        const shipEl = document.getElementById('summaryShipping');
        const totEl = document.getElementById('summaryTotal');
        if (subEl) subEl.textContent = fmt(subtotal);
        if (shipEl) shipEl.textContent = shipping > 0 ? fmt(shipping) : 'Miễn phí';
        if (totEl) totEl.textContent = fmt(total);
    }

    // ── Flash sale countdown timer ────────────────────────────────
    function initCountdown() {
        const el = document.getElementById('countdown');
        if (!el) return;
        const endTime = new Date(el.dataset.end).getTime();
        function tick() {
            const diff = endTime - Date.now();
            if (diff <= 0) { el.innerHTML = '<span class="ended">Đã kết thúc</span>'; return; }
            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            const pad = n => String(n).padStart(2, '0');
            const hrs = document.getElementById('cdHours');
            const mins = document.getElementById('cdMins');
            const secs = document.getElementById('cdSecs');
            if (hrs) hrs.textContent = pad(h);
            if (mins) mins.textContent = pad(m);
            if (secs) secs.textContent = pad(s);
        }
        tick();
        setInterval(tick, 1000);
    }

    // ── Sticky header ─────────────────────────────────────────────
    function initStickyHeader() {
        const header = document.getElementById('siteHeader');
        if (!header) return;
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 60);
        }, { passive: true });
    }

    // ── Mobile nav ────────────────────────────────────────────────
    function initMobileMenu() {
        const btn = document.getElementById('mobileMenuBtn');
        const nav = document.getElementById('mainNav');
        if (!btn || !nav) return;
        btn.addEventListener('click', () => {
            nav.classList.toggle('open');
            btn.classList.toggle('active');
        });
    }

    // ── User dropdown ─────────────────────────────────────────────
    function initUserDropdown() {
        const btn = document.getElementById('userMenuBtn');
        const drop = document.getElementById('userDropdown');
        if (!btn || !drop) return;
        btn.addEventListener('click', e => { e.stopPropagation(); drop.classList.toggle('show'); });
        document.addEventListener('click', () => drop.classList.remove('show'));
    }

    // ── Flash banner auto-dismiss ─────────────────────────────────
    function initFlash() {
        const banner = document.getElementById('flashBanner');
        if (banner) setTimeout(() => banner.remove(), 4000);
    }

    // ── Lazy loading images ───────────────────────────────────────
    function initLazyLoad() {
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(e => { if (e.isIntersecting) { e.target.src = e.target.dataset.src; observer.unobserve(e.target); } });
            }, { rootMargin: '200px' });
            document.querySelectorAll('img[data-src]').forEach(img => observer.observe(img));
        }
    }

    // ── Init ──────────────────────────────────────────────────────
    function escapeHtml(value) {
        return String(value).replace(/[&<>"']/g, ch => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        }[ch]));
    }

    function initSearchSuggest() {
        const input = document.getElementById('main-search');
        const box = document.getElementById('searchSuggestBox');
        if (!input || !box) return;

        let timer = null;
        let requestId = 0;
        let activeIndex = -1;
        let items = [];

        input.setAttribute('autocomplete', 'off');
        input.setAttribute('aria-autocomplete', 'list');
        input.setAttribute('aria-expanded', 'false');
        input.setAttribute('aria-controls', 'searchSuggestBox');

        function hideSuggest() {
            box.classList.add('d-none');
            box.innerHTML = '';
            input.setAttribute('aria-expanded', 'false');
            activeIndex = -1;
            items = [];
        }

        function setActive(nextIndex) {
            const links = box.querySelectorAll('[data-suggest-index]');
            links.forEach(el => el.classList.remove('active'));
            if (nextIndex < 0 || nextIndex >= links.length) {
                activeIndex = -1;
                return;
            }
            activeIndex = nextIndex;
            links[activeIndex].classList.add('active');
            links[activeIndex].scrollIntoView({ block: 'nearest' });
        }

        function renderSuggest(data) {
            items = Array.isArray(data) ? data : [];
            if (!items.length) {
                hideSuggest();
                return;
            }

            box.innerHTML = items.map((item, index) => `
                <a href="${escapeHtml(item.url)}" class="list-group-item list-group-item-action border-0 border-bottom py-3" data-suggest-index="${index}">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-light rounded-3 overflow-hidden flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            ${item.image
                                ? `<img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}" class="w-100 h-100" style="object-fit: cover;">`
                                : `<span class="material-symbols-rounded text-secondary">image</span>`}
                        </div>
                        <div class="min-w-0 flex-grow-1">
                            <div class="fw-medium text-dark text-truncate">${escapeHtml(item.name)}</div>
                            <div class="small text-muted text-truncate">${escapeHtml(item.category_name || '')}</div>
                        </div>
                        <div class="text-danger fw-semibold text-nowrap">${escapeHtml(item.price_text)}</div>
                    </div>
                </a>
            `).join('');

            box.classList.remove('d-none');
            input.setAttribute('aria-expanded', 'true');
            activeIndex = -1;
        }

        function fetchSuggest(keyword) {
            requestId += 1;
            const currentId = requestId;
            fetch(`${BASE_URL}/search/suggest?q=${encodeURIComponent(keyword)}`)
                .then(r => r.ok ? r.json() : Promise.reject())
                .then(data => {
                    if (currentId !== requestId) return;
                    renderSuggest(data.items || []);
                })
                .catch(() => {
                    if (currentId !== requestId) return;
                    hideSuggest();
                });
        }

        input.addEventListener('input', () => {
            const keyword = input.value.trim();
            clearTimeout(timer);
            if (keyword.length < 1) {
                hideSuggest();
                return;
            }
            timer = setTimeout(() => fetchSuggest(keyword), 180);
        });

        input.addEventListener('keydown', e => {
            const links = box.querySelectorAll('[data-suggest-index]');
            if (!links.length) return;

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                setActive(activeIndex + 1 >= links.length ? 0 : activeIndex + 1);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                setActive(activeIndex - 1 < 0 ? links.length - 1 : activeIndex - 1);
            } else if (e.key === 'Enter' && activeIndex >= 0) {
                e.preventDefault();
                links[activeIndex].click();
            } else if (e.key === 'Escape') {
                hideSuggest();
            }
        });

        document.addEventListener('click', e => {
            if (!box.contains(e.target) && e.target !== input) hideSuggest();
        });

        input.form?.addEventListener('submit', hideSuggest);
    }

    document.addEventListener('DOMContentLoaded', () => {
        fetchCartCount();
        syncGuestCartOnLogin();
        initCountdown();
        initStickyHeader();
        initMobileMenu();
        initUserDropdown();
        initFlash();
        initLazyLoad();
        initSearchSuggest();
        bindCartActions();
        recalcCartSummary();
    });

})();
