/* ================================================================
   SONNE E-commerce – app.js
   ================================================================ */
'use strict';

// ─── Data ───────────────────────────────────────────────────────

const FLASH_PRODUCTS = [
    { id: 1, name: 'Tai nghe Sony WH-1000XM5 Chống Ồn Chủ Động', img: 'https://picsum.photos/seed/sony1/400/400', oldPrice: 8990000, newPrice: 5990000, disc: 33, sold: 72, total: 100, desc: 'Tai nghe over-ear không dây cao cấp với công nghệ chống ồn chủ động tốt nhất trong phân khúc, pin 30 giờ.' },
    { id: 2, name: 'Bàn phím cơ Keychron K2 Pro Wireless RGB', img: 'https://picsum.photos/seed/key2/400/400', oldPrice: 3200000, newPrice: 1990000, disc: 38, sold: 84, total: 150, desc: 'Bàn phím cơ compact 75% không dây, kết nối đa thiết bị, switch Gateron Pro.' },
    { id: 3, name: 'Áo phông basic Oversized Form Rộng Unisex', img: 'https://picsum.photos/seed/cloth3/400/400', oldPrice: 450000, newPrice: 259000, disc: 42, sold: 91, total: 200, desc: 'Chất liệu cotton 100%, form rộng thoải mái, nhiều màu sắc trẻ trung.' },
    { id: 4, name: 'Đèn LED Máy Tính RGB Gaming Atmosphere Light', img: 'https://picsum.photos/seed/lamp4/400/400', oldPrice: 890000, newPrice: 490000, disc: 45, sold: 60, total: 80, desc: 'Dải đèn LED RGB thông minh điều khiển bằng app, 16 triệu màu sắc.' },
    { id: 5, name: 'Chuột gaming Logitech G502 Hero High Performance', img: 'https://picsum.photos/seed/mouse5/400/400', oldPrice: 2100000, newPrice: 1290000, disc: 39, sold: 55, total: 70, desc: 'Chuột gaming 25K DPI, 11 nút tùy chỉnh, thiết kế ergonomic chuyên nghiệp.' },
    { id: 6, name: 'Máy pha cà phê Delonghi Dedica EC685 Espresso', img: 'https://picsum.photos/seed/coffee6/400/400', oldPrice: 5500000, newPrice: 3790000, disc: 31, sold: 40, total: 60, desc: 'Máy pha espresso bán tự động, thân thiết kế slim, hơi nước tạo bọt sữa mịn.' },
    { id: 7, name: 'Balo Laptop 15.6" chống nước Anker A7103', img: 'https://picsum.photos/seed/bag7/400/400', oldPrice: 1200000, newPrice: 690000, disc: 42, sold: 76, total: 120, desc: 'Chất liệu chống nước, nhiều ngăn tiện dụng, ngăn riêng cho laptop.' },
    { id: 8, name: 'Sách "Atomic Habits" - James Clear (Bản dịch)', img: 'https://picsum.photos/seed/book8/400/400', oldPrice: 149000, newPrice: 89000, disc: 40, sold: 88, total: 100, desc: 'Cuốn sách thay đổi thói quen bán chạy toàn cầu, dịch ra hơn 40 ngôn ngữ.' },
];

const REC_PRODUCTS = [
    { id: 101, name: 'iPhone 15 Pro Max 256GB', img: 'https://picsum.photos/seed/iph101/400/400', price: 31990000, rating: 4.9, reviews: 2341 },
    { id: 102, name: 'Samsung Galaxy S24 Ultra', img: 'https://picsum.photos/seed/sam102/400/400', price: 28990000, rating: 4.8, reviews: 1892 },
    { id: 103, name: 'MacBook Air M3 13" 8GB 256GB', img: 'https://picsum.photos/seed/mac103/400/400', price: 27990000, rating: 4.9, reviews: 987 },
    { id: 104, name: 'Sneakers Nike Air Max 270 Triple White', img: 'https://picsum.photos/seed/nik104/400/400', price: 2990000, rating: 4.7, reviews: 5621 },
    { id: 105, name: 'Kem chống nắng Anessa Perfect UV SPF50+', img: 'https://picsum.photos/seed/sun105/400/400', price: 499000, rating: 4.8, reviews: 8901 },
    { id: 106, name: 'Nồi chiên không dầu Philips HD9270', img: 'https://picsum.photos/seed/phi106/400/400', price: 2590000, rating: 4.6, reviews: 3211 },
    { id: 107, name: 'Máy lọc không khí Xiaomi Air Purifier 4 Pro', img: 'https://picsum.photos/seed/xia107/400/400', price: 4290000, rating: 4.7, reviews: 1234 },
    { id: 108, name: 'Đồng hồ thông minh Apple Watch Series 9', img: 'https://picsum.photos/seed/apl108/400/400', price: 9990000, rating: 4.9, reviews: 4567 },
    { id: 109, name: 'Ghế Gaming DXRacer Craft Series', img: 'https://picsum.photos/seed/gam109/400/400', price: 7500000, rating: 4.5, reviews: 876 },
    { id: 110, name: 'Đèn bàn charging không dây LED Baseus', img: 'https://picsum.photos/seed/led110/400/400', price: 890000, rating: 4.6, reviews: 2109 },
];

const SHOPS = [
    { id: 1, name: 'Thời Trang Official', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuApKFzQ75BValwFHPApENtunG-0n97abSy_ZJRfaXKBdF_as0wHPKkrlJV2jXsNg2OmeIDk19r0M59TRB9Wzz9NEM3p1RMyM9n1m1L6pcYae3Ync70USfsa7qf4dW0WugrdAOH-pa4NFwGRioAHBVZ4SyA3-gM1IZ6yLMukVo0mKbvLrVU8-i0jktq72tO0D7iObOp5GNYtRyU5U3zqJXU5JLBijgdxrew-g27J5yKM', rating: 4.9, followers: '20k+' },
    { id: 2, name: 'Tech Zone VN', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCCFSf4Yuo8l8oTzZlWFK1AzYuxwVhRvlwbKgh4BZ2wLRYFo_9VleDx-ZgWmj2DSUFkwXGbTMmElpi8j5bjfA1bYgqLAVHlLFIJ5jVk1svHHXpziG5E1MzeuA3kdHkbGE-Ofjl_iQ6vM8iLl6U0Mn37L6hMdua2KzYTatSYvFK9skT68yCpepWvRXNwWLCfsJrQirG-zPyfThRmD4wsLdYIh4zD2ng7_m02', rating: 4.8, followers: '15k+' },
    { id: 3, name: 'Nhà Xinh Decor', avatar: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDaRpOIIIGeKaaHMKdrmIknC0_fVbJi5yRb62bXycBlN5WKVWbdSYU5SbJwhlmgAMetbh5u-z7MTdOJriDO2jfaxcl9TpUa6qC3fScj_FdHhjQnQK25YNuTWmv0nnujBIPVmwAU5NqN7yCKcw47-OP8j6Xv7pufA0WZZx8cMlXFwJeSIsA0FX6a_UPAcxPJ3y79zCAVR4_3bzB5O2I7oHYb2MOyW1gU8Hd4bsDWDqZwRsTsFGJwEnzFnq6Jr1h4GgP0JJ', rating: 5.0, followers: '5k+' },
];

// ─── Utilities ──────────────────────────────────────────────────

function formatVND(n) {
    return new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(n);
}

function stars(rating) {
    const full = Math.floor(rating);
    const half = rating % 1 >= 0.5;
    let s = '';
    for (let i = 0; i < full; i++) s += '★';
    if (half) s += '½';
    return s;
}

// ─── Countdown Timer ────────────────────────────────────────────

(function initCountdown() {
    const hEl = document.getElementById('cd-h');
    const mEl = document.getElementById('cd-m');
    const sEl = document.getElementById('cd-s');

    // Stop if countdown elements don't exist on this page
    if (!hEl || !mEl || !sEl) return;

    // Set end time 4h 27m 51s from now
    const end = new Date();
    end.setHours(end.getHours() + 4, end.getMinutes() + 27, end.getSeconds() + 51);

    function tick() {
        const diff = Math.max(0, Math.floor((end - Date.now()) / 1000));
        const h = Math.floor(diff / 3600);
        const m = Math.floor((diff % 3600) / 60);
        const s = diff % 60;
        hEl.textContent = String(h).padStart(2, '0');
        mEl.textContent = String(m).padStart(2, '0');
        sEl.textContent = String(s).padStart(2, '0');

        // Pulse animation on second change
        [hEl, mEl, sEl].forEach(el => {
            el.parentElement.style.animation = 'none';
            el.parentElement.offsetHeight; // reflow
            el.parentElement.style.animation = '';
        });

        if (diff > 0) setTimeout(tick, 1000);
    }
    tick();
})();

// ─── Flash Sale Cards ─────────────────────────────────────────

function renderFlashCards() {
    const track = document.getElementById('flash-track');
    if (!track) return;
    track.innerHTML = FLASH_PRODUCTS.map(p => `
    <div class="flash-card" data-id="${p.id}" tabindex="0" role="button" aria-label="Xem chi tiết ${p.name}">
      <div class="flash-img-wrap">
        <img src="${p.img}" alt="${p.name}" class="flash-img" loading="lazy" />
        <span class="disc-badge">-${p.disc}%</span>
      </div>
      <div class="flash-info">
        <p class="flash-name">${p.name}</p>
        <div class="price-row">
          <span class="price-new">${formatVND(p.newPrice)}</span>
          <span class="price-old">${formatVND(p.oldPrice)}</span>
        </div>
        <div class="sold-row">
          <span class="sold-label">Đã bán ${p.sold}%</span>
          <div class="progress-bar"><div class="progress-fill" style="width:${p.sold}%"></div></div>
        </div>
        <button class="flash-btn">Xem chi tiết</button>
      </div>
    </div>
  `).join('');

    // Attach click events
    track.querySelectorAll('.flash-card').forEach(card => {
        card.addEventListener('click', () => openProductModal(card.dataset.id, 'flash'));
        card.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') openProductModal(card.dataset.id, 'flash'); });
    });
}

// ─── Recommended Products ────────────────────────────────────

function renderRecommended() {
    const grid = document.getElementById('rec-grid');
    if (!grid) return;

    // Simulate lazy load with delay
    setTimeout(() => {
        grid.innerHTML = REC_PRODUCTS.map(p => `
      <div class="product-card" data-id="${p.id}" tabindex="0" role="button" aria-label="Xem ${p.name}">
        <div class="prod-img-wrap">
          <img src="${p.img}" alt="${p.name}" class="prod-img" loading="lazy" />
        </div>
        <div class="prod-info">
          <p class="prod-name">${p.name}</p>
          <div class="prod-rating">
            <span>${stars(p.rating)}</span>
            <span style="color:var(--gray-400)">(${p.reviews.toLocaleString('vi')})</span>
          </div>
          <p class="prod-price">${formatVND(p.price)}</p>
        </div>
      </div>
    `).join('');

        // Animate cards in
        grid.querySelectorAll('.product-card').forEach((card, i) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(16px)';
            setTimeout(() => {
                card.style.transition = 'opacity .4s ease, transform .4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, i * 60);
        });
    }, 1200); // 1.2s skeleton delay
}

// ─── Featured Shops ──────────────────────────────────────────

function renderShops() {
    const grid = document.getElementById('shops-grid');
    if (!grid) return;
    grid.innerHTML = SHOPS.map(s => `
    <div class="shop-card" data-aos>
      <img src="${s.avatar}" alt="${s.name}" class="shop-avatar" loading="lazy" />
      <div class="shop-info">
        <p class="shop-name">${s.name}</p>
        <div class="shop-meta">
          <span class="shop-stars">★ ${s.rating}</span>
          <span>|</span>
          <span class="shop-count">${s.followers} Follower</span>
        </div>
        <button class="shop-btn" aria-label="Xem shop ${s.name}">Xem shop</button>
      </div>
    </div>
  `).join('');
}

// ─── Product Modal ───────────────────────────────────────────

const overlay = document.getElementById('modal-overlay');
const closeBtn = document.getElementById('modal-close');
const addCartBtn = document.getElementById('modal-add-cart');
const wishlistBtn = document.getElementById('modal-wishlist');

function openProductModal(id, source) {
    const all = source === 'flash' ? FLASH_PRODUCTS : REC_PRODUCTS;
    const p = all.find(x => x.id === parseInt(id));
    if (!p) return;

    document.getElementById('modal-img').src = p.img;
    document.getElementById('modal-img').alt = p.name;
    document.getElementById('modal-title').textContent = p.name;
    document.getElementById('modal-new-price').textContent = formatVND(p.newPrice || p.price);
    document.getElementById('modal-old-price').textContent = p.oldPrice ? formatVND(p.oldPrice) : '';
    document.getElementById('modal-badge').textContent = p.disc ? `-${p.disc}%` : '';
    document.getElementById('modal-badge').style.display = p.disc ? '' : 'none';
    document.getElementById('modal-rating').textContent = '★ ' + (p.rating || 4.8) + ' | ' + ((p.reviews || p.sold + '%'));
    document.getElementById('modal-sold').textContent = p.total ? `Đã bán ${p.sold}/${p.total}` : '';
    const pct = p.sold || 0;
    document.getElementById('modal-sold-pct').textContent = pct + '%';
    document.getElementById('modal-prog-fill').style.width = pct + '%';
    document.getElementById('modal-desc').textContent = p.desc || 'Sản phẩm chính hãng, chất lượng cao.';
    document.getElementById('modal-progress-wrap')?.style;

    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
}

closeBtn?.addEventListener('click', closeModal);
overlay?.addEventListener('click', e => { if (e.target === overlay) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// Cart interaction
let cartCount = 3;
addCartBtn?.addEventListener('click', () => {
    cartCount++;
    document.getElementById('cartCount').textContent = cartCount;
    showToast('Đã thêm vào giỏ hàng!');
    closeModal();
});

wishlistBtn?.addEventListener('click', () => {
    const icon = wishlistBtn.querySelector('.material-icons-round');
    icon.textContent = icon.textContent === 'favorite_border' ? 'favorite' : 'favorite_border';
    icon.style.color = icon.textContent === 'favorite' ? '#FF4D4D' : '';
    showToast('Đã thêm vào danh sách yêu thích!');
});

// ─── Toast ──────────────────────────────────────────────────

const toast = document.getElementById('toast');
const toastMsg = document.getElementById('toast-msg');
let toastTimer;

function showToast(msg) {
    toastMsg.textContent = msg;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 3000);
}

// ─── Sticky Header Shadow ────────────────────────────────────

window.addEventListener('scroll', () => {
    const header = document.getElementById('siteHeader');
    header.classList.toggle('scrolled', window.scrollY > 10);
}, { passive: true });

// ─── AOS-lite Scroll Animations ─────────────────────────────

const aosEls = document.querySelectorAll('[data-aos]');
const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            // Stagger if multiple children
            const delay = entry.target.dataset.aosDelay || 0;
            setTimeout(() => {
                entry.target.classList.add('animated');
            }, delay);
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

aosEls.forEach((el, i) => {
    // Stagger siblings
    const siblings = el.parentElement ? [...el.parentElement.querySelectorAll('[data-aos]')] : [];
    const idx = siblings.indexOf(el);
    if (idx > 0) el.dataset.aosDelay = idx * 60;
    observer.observe(el);
});

// Re-observe dynamically added elements
function observeNewAos() {
    document.querySelectorAll('[data-aos]:not(.animated)').forEach(el => observer.observe(el));
}

// ─── Search input keyboard shortcut ─────────────────────────

document.addEventListener('keydown', e => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        document.getElementById('main-search')?.focus();
    }
});

// ─── Cart button animation ───────────────────────────────────

document.getElementById('cart-btn')?.addEventListener('click', () => {
    showToast('Giỏ hàng của bạn có ' + cartCount + ' sản phẩm');
});

// ─── Init ─────────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
    renderFlashCards();
    renderRecommended();
    renderShops();
    setTimeout(observeNewAos, 1500);
});

// Handle dynamic content after skeleton loads
setTimeout(observeNewAos, 1500);

// ─── PDP Specific Logic ─────────────────────────────────────────

// Gallery
const pdpMainImg = document.getElementById('pdp-main-img');
const pdpThumbs = document.querySelectorAll('.thumb-btn');
if (pdpMainImg && pdpThumbs.length > 0) {
    pdpThumbs.forEach(btn => {
        btn.addEventListener('click', () => {
            pdpThumbs.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const newSrc = btn.querySelector('img').src;
            pdpMainImg.style.opacity = '0';
            setTimeout(() => {
                pdpMainImg.src = newSrc;
                pdpMainImg.style.opacity = '1';
            }, 200);
        });
    });
}

// Variants
const varBtns = document.querySelectorAll('.var-btn');
varBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const group = btn.closest('.variant-options');
        group.querySelectorAll('.var-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    });
});

// Quantity
const qtyMinus = document.getElementById('qty-minus');
const qtyPlus = document.getElementById('qty-plus');
const qtyInput = document.getElementById('qty-input');
if (qtyInput) {
    qtyMinus.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v > 1) qtyInput.value = v - 1;
    });
    qtyPlus.addEventListener('click', () => {
        let v = parseInt(qtyInput.value) || 1;
        if (v < 99) qtyInput.value = v + 1;
    });
    qtyInput.addEventListener('change', () => {
        let v = parseInt(qtyInput.value);
        if (isNaN(v) || v < 1) qtyInput.value = 1;
        if (v > 99) qtyInput.value = 99;
    });
}

// PDP Actions
const pdpAddCart = document.getElementById('pdp-add-cart');
const pdpBuyNow = document.getElementById('pdp-buy-now');
if (pdpAddCart) {
    pdpAddCart.addEventListener('click', () => {
        let qty = parseInt(qtyInput ? qtyInput.value : 1);
        cartCount += qty;
        document.getElementById('cartCount').textContent = cartCount;
        showToast(`Đã thêm ${qty} sản phẩm vào giỏ hàng!`);
    });
}
if (pdpBuyNow) {
    pdpBuyNow.addEventListener('click', () => {
        window.location.href = '#'; // Redirect to checkout
    });
}

// Tabs
const tabBtns = document.querySelectorAll('.tab-btn[data-tab]');
if (tabBtns.length > 0) {
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const targetId = btn.dataset.tab;
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            document.getElementById(targetId).classList.add('active');
        });
    });
}

// Expand Description
const readMoreBtn = document.getElementById('read-more-btn');
const descContent = document.getElementById('desc-content');
if (readMoreBtn && descContent) {
    readMoreBtn.addEventListener('click', () => {
        descContent.classList.add('expanded');
        // The overlay is hidden via CSS when .expanded is present
    });
}
