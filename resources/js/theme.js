/*
 * Vanilla replacements for the Dorbesh theme's jQuery plugins, written so
 * they can be re-run after every wire:navigate visit.
 */

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

/**
 * Listeners on window/document survive navigation, so they are bound once.
 */
export function initGlobalListeners() {
    window.addEventListener('scroll', onScroll, { passive: true });

    document.addEventListener('click', (event) => {
        const toggle = event.target.closest('.navbar-toggle');

        if (toggle) {
            document.querySelector('.main-menu .navbar-collapse')?.classList.toggle('show');
            toggle.setAttribute('aria-expanded', toggle.getAttribute('aria-expanded') === 'true' ? 'false' : 'true');

            return;
        }

        if (event.target.closest('.main-menu .navbar-collapse a')) {
            document.querySelector('.main-menu .navbar-collapse')?.classList.remove('show');
        }

        if (event.target.closest('.progress-wrap')) {
            event.preventDefault();
            window.scrollTo({ top: 0, behavior: reducedMotion.matches ? 'auto' : 'smooth' });
        }

        const dismiss = event.target.closest('[data-bs-dismiss="alert"]');

        if (dismiss) {
            dismiss.closest('.alert')?.remove();
        }
    });
}

export function initTheme() {
    if (document.body.dataset.themeReady) {
        return;
    }

    document.body.dataset.themeReady = 'true';

    initScrollers();
    initProjectFilter();
    initReveal();
    onScroll();
}

function onScroll() {
    const scrolled = window.scrollY;

    document.querySelector('.main-header')?.classList.toggle('fixed-header', scrolled >= 100);

    const progress = document.querySelector('.progress-wrap');
    const path = progress?.querySelector('path');

    if (!progress || !path) {
        return;
    }

    const length = path.getTotalLength();
    const height = document.documentElement.scrollHeight - window.innerHeight;

    path.style.strokeDasharray = `${length} ${length}`;
    path.style.strokeDashoffset = height > 0 ? length - (scrolled * length) / height : length;
    progress.classList.toggle('active-progress', scrolled > 150);
}

/**
 * Infinite marquee: duplicate the items once so the CSS animation loops.
 */
function initScrollers() {
    if (reducedMotion.matches) {
        return;
    }

    document.querySelectorAll('.scroller:not([data-animated])').forEach((scroller) => {
        const inner = scroller.querySelector('.scroller__inner');

        if (!inner) {
            return;
        }

        scroller.setAttribute('data-animated', 'true');

        Array.from(inner.children).forEach((item) => {
            const copy = item.cloneNode(true);
            copy.setAttribute('aria-hidden', 'true');
            inner.appendChild(copy);
        });
    });
}

/**
 * Category filter on the works page.
 */
function initProjectFilter() {
    document.querySelectorAll('.project-filter').forEach((filter) => {
        const grid = filter.parentElement.querySelector('.project-masonry-active');

        filter.querySelectorAll('[data-filter]').forEach((button) => {
            button.addEventListener('keydown', (event) => {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    button.click();
                }
            });

            button.addEventListener('click', () => {
                const selected = button.dataset.filter;

                filter.querySelectorAll('[data-filter]').forEach((other) => {
                    other.classList.toggle('current', other === button);
                    other.setAttribute('aria-pressed', other === button ? 'true' : 'false');
                });

                grid?.querySelectorAll('.item').forEach((item) => {
                    const categories = (item.dataset.categories || '').split(' ');

                    item.classList.toggle('is-hidden', selected !== '*' && !categories.includes(selected));
                });
            });
        });
    });
}

/**
 * Animate.css entrance animations when elements scroll into view (what
 * wow.js used to do). Only elements below the first screen are hidden
 * first, so above-the-fold content (and LCP) is never delayed.
 */
function initReveal() {
    if (reducedMotion.matches || !('IntersectionObserver' in window)) {
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.remove('wow-pending');
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, { rootMargin: '0px 0px -40px 0px' });

    document.querySelectorAll('.wow:not(.animated)').forEach((element) => {
        if (element.getBoundingClientRect().top < window.innerHeight) {
            return;
        }

        element.classList.add('wow-pending');
        observer.observe(element);
    });
}
