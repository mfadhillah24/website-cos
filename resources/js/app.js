import './bootstrap';


// ==========================================
// IMAGE POPUP / LIGHTBOX
// ==========================================
document.addEventListener('DOMContentLoaded', () => {

    let imageModal = null;
    let modalImage = null;
    let modalClose = null;
    let modalCaption = null;

    let galleryImages = [];
    let currentImageIndex = 0;


    // ==========================================
    // CREATE IMAGE MODAL
    // ==========================================

    function createImageModal() {

        if (document.getElementById('custom-image-modal')) {
            imageModal = document.getElementById('custom-image-modal');
            modalImage = document.getElementById('custom-modal-image');
            modalClose = document.getElementById('custom-modal-close');
            modalCaption = document.getElementById('custom-modal-caption');

            return;
        }


        imageModal = document.createElement('div');

        imageModal.id = 'custom-image-modal';

        imageModal.innerHTML = `
            <div class="custom-modal-overlay">

                <button
                    type="button"
                    id="custom-modal-close"
                    aria-label="Tutup"
                    title="Tutup"
                >
                    &times;
                </button>


                <button
                    type="button"
                    id="custom-modal-prev"
                    class="custom-modal-nav custom-modal-prev"
                    aria-label="Foto sebelumnya"
                >
                    &#10094;
                </button>


                <img
                    id="custom-modal-image"
                    src=""
                    alt="Dokumentasi"
                >


                <button
                    type="button"
                    id="custom-modal-next"
                    class="custom-modal-nav custom-modal-next"
                    aria-label="Foto berikutnya"
                >
                    &#10095;
                </button>


                <div id="custom-modal-caption"></div>

            </div>
        `;


        document.body.appendChild(imageModal);


        modalImage =
            document.getElementById('custom-modal-image');

        modalClose =
            document.getElementById('custom-modal-close');

        modalCaption =
            document.getElementById('custom-modal-caption');


        // ==========================================
        // CLOSE BUTTON
        // ==========================================

        modalClose.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            closeImageModal();

        });


        // ==========================================
        // CLICK BACKGROUND TO CLOSE
        // ==========================================

        imageModal.addEventListener('click', function (event) {

            if (
                event.target === imageModal ||
                event.target.classList.contains('custom-modal-overlay')
            ) {
                closeImageModal();
            }

        });


        // ==========================================
        // PREVIOUS
        // ==========================================

        const previousButton =
            document.getElementById('custom-modal-prev');


        previousButton.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            if (galleryImages.length <= 1) {
                return;
            }

            currentImageIndex--;

            if (currentImageIndex < 0) {
                currentImageIndex =
                    galleryImages.length - 1;
            }

            showCurrentImage();

        });


        // ==========================================
        // NEXT
        // ==========================================

        const nextButton =
            document.getElementById('custom-modal-next');


        nextButton.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            if (galleryImages.length <= 1) {
                return;
            }

            currentImageIndex++;

            if (
                currentImageIndex >=
                galleryImages.length
            ) {
                currentImageIndex = 0;
            }

            showCurrentImage();

        });

    }


    // ==========================================
    // OPEN IMAGE
    // ==========================================

    function openImage(imageUrl, caption = '') {

        createImageModal();


        // ==========================================
        // COLLECT ALL GALLERY IMAGES
        // ==========================================

        galleryImages = [];


        const galleryLinks =
            document.querySelectorAll(
                'a.gallery-thumb, a.documentation-image'
            );


        galleryLinks.forEach(function (link) {

            let url = '';

            let text = '';


            if (link.tagName === 'A') {

                url =
                    link.getAttribute('href');

                text =
                    link.getAttribute('data-description') ||
                    link.getAttribute('data-caption') ||
                    link.querySelector('img')?.alt ||
                    '';

            } else {

                url =
                    link.getAttribute('data-image');

                text =
                    link.getAttribute('data-caption') ||
                    link.querySelector('img')?.alt ||
                    '';

            }


            if (
                url &&
                isImageUrl(url)
            ) {

                galleryImages.push({
                    url: url,
                    caption: text
                });

            }

        });


        // ==========================================
        // IF CLICKED IMAGE IS NOT IN GALLERY
        // ==========================================

        const existingIndex =
            galleryImages.findIndex(function (item) {

                return item.url === imageUrl;

            });


        if (existingIndex !== -1) {

            currentImageIndex = existingIndex;

        } else {

            galleryImages.unshift({
                url: imageUrl,
                caption: caption
            });

            currentImageIndex = 0;

        }


        showCurrentImage();


        imageModal.classList.add('active');

        document.body.classList.add(
            'custom-image-modal-open'
        );

    }


    // ==========================================
    // SHOW CURRENT IMAGE
    // ==========================================

    function showCurrentImage() {

        if (
            !galleryImages.length ||
            !modalImage
        ) {
            return;
        }


        const current =
            galleryImages[currentImageIndex];


        modalImage.src =
            current.url;


        modalImage.alt =
            current.caption || 'Dokumentasi';


        modalCaption.textContent =
            current.caption || '';


        const previousButton =
            document.getElementById('custom-modal-prev');


        const nextButton =
            document.getElementById('custom-modal-next');


        if (galleryImages.length <= 1) {

            previousButton.style.display = 'none';
            nextButton.style.display = 'none';

        } else {

            previousButton.style.display = 'flex';
            nextButton.style.display = 'flex';

        }

    }


    // ==========================================
    // CLOSE IMAGE MODAL
    // ==========================================

    function closeImageModal() {

        if (!imageModal) {
            return;
        }


        imageModal.classList.remove('active');

        document.body.classList.remove(
            'custom-image-modal-open'
        );


        if (modalImage) {
            modalImage.src = '';
        }

    }


    // ==========================================
    // CHECK IMAGE URL
    // ==========================================

    function isImageUrl(url) {

        if (!url) {
            return false;
        }


        const cleanUrl =
            url.split('?')[0].toLowerCase();


        return (
            cleanUrl.endsWith('.jpg') ||
            cleanUrl.endsWith('.jpeg') ||
            cleanUrl.endsWith('.png') ||
            cleanUrl.endsWith('.webp') ||
            cleanUrl.endsWith('.gif') ||
            cleanUrl.endsWith('.avif')
        );

    }


    // ==========================================
    // IMPORTANT:
    // INTERCEPT IMAGE LINKS BEFORE OTHER SCRIPTS
    // ==========================================

    document.addEventListener(
        'click',
        function (event) {

            const link =
                event.target.closest('a');


            if (!link) {
                return;
            }


            const href =
                link.getAttribute('href');


            if (!href) {
                return;
            }


            // ======================================
            // CHECK IF THIS IS AN IMAGE LINK
            // ======================================

            if (!isImageUrl(href)) {
                return;
            }


            // ======================================
            // STOP BROWSER NAVIGATION
            // ======================================

            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();


            // ======================================
            // GET IMAGE
            // ======================================

            const image =
                link.querySelector('img');


            const caption =
                link.getAttribute('data-description') ||
                link.getAttribute('data-caption') ||
                image?.getAttribute('alt') ||
                '';


            let imageUrl =
                href;


            /*
             * Jika URL relatif, ubah menjadi URL lengkap.
             */

            try {

                imageUrl =
                    new URL(
                        href,
                        window.location.origin
                    ).href;

            } catch (error) {

                imageUrl = href;

            }


            openImage(
                imageUrl,
                caption
            );


        },
        true
    );


    // ==========================================
    // ALSO HANDLE DOCUMENTATION BUTTON
    // ==========================================

    document.addEventListener(
        'click',
        function (event) {

            const button =
                event.target.closest(
                    '.documentation-image'
                );


            if (!button) {
                return;
            }


            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();


            const imageUrl =
                button.getAttribute(
                    'data-image'
                );


            const caption =
                button.getAttribute(
                    'data-caption'
                ) || '';


            if (imageUrl) {

                openImage(
                    imageUrl,
                    caption
                );

            }

        },
        true
    );


    // ==========================================
    // ESC TO CLOSE
    // ==========================================

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                !imageModal ||
                !imageModal.classList.contains('active')
            ) {
                return;
            }


            if (event.key === 'Escape') {

                closeImageModal();

            }


            if (event.key === 'ArrowLeft') {

                const previousButton =
                    document.getElementById(
                        'custom-modal-prev'
                    );

                if (previousButton) {
                    previousButton.click();
                }

            }


            if (event.key === 'ArrowRight') {

                const nextButton =
                    document.getElementById(
                        'custom-modal-next'
                    );

                if (nextButton) {
                    nextButton.click();
                }

            }

        }
    );


    // ==========================================
    // MODAL CSS
    // ==========================================

    const modalStyle =
        document.createElement('style');


    modalStyle.textContent = `

        #custom-image-modal {
            position: fixed;
            inset: 0;

            display: none;

            align-items: center;
            justify-content: center;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, 0.94);

            z-index: 999999;
        }


        #custom-image-modal.active {
            display: flex;
        }


        .custom-modal-overlay {
            position: relative;

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            padding: 60px 80px;
        }


        #custom-modal-image {
            display: block;

            max-width: 92vw;
            max-height: 88vh;

            width: auto;
            height: auto;

            object-fit: contain;

            border-radius: 8px;

            box-shadow:
                0 25px 50px rgba(0, 0, 0, 0.5);

            animation:
                customModalZoom
                0.25s ease;
        }


        @keyframes customModalZoom {

            from {
                opacity: 0;
                transform: scale(0.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }

        }


        #custom-modal-close {
            position: fixed;

            top: 20px;
            right: 25px;

            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 0;

            border: 1px solid
                rgba(255, 255, 255, 0.4);

            border-radius: 50%;

            background:
                rgba(0, 0, 0, 0.7);

            color: white;

            font-family: Arial, sans-serif;

            font-size: 36px;
            font-weight: 300;

            line-height: 1;

            cursor: pointer;

            z-index: 1000001;

            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }


        #custom-modal-close:hover {
            background:
                rgba(255, 255, 255, 0.2);

            transform: scale(1.08);
        }


        .custom-modal-nav {
            position: fixed;

            top: 50%;

            transform: translateY(-50%);

            width: 48px;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            border: 1px solid
                rgba(255, 255, 255, 0.3);

            border-radius: 50%;

            background:
                rgba(0, 0, 0, 0.6);

            color: white;

            font-size: 28px;

            cursor: pointer;

            z-index: 1000001;

            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }


        .custom-modal-nav:hover {
            background:
                rgba(255, 255, 255, 0.2);
        }


        .custom-modal-prev {
            left: 20px;
        }


        .custom-modal-next {
            right: 20px;
        }


        #custom-modal-caption {
            position: fixed;

            left: 50%;
            bottom: 20px;

            transform: translateX(-50%);

            max-width: 80vw;

            padding: 8px 16px;

            border-radius: 6px;

            background:
                rgba(0, 0, 0, 0.7);

            color: white;

            font-size: 14px;

            text-align: center;

            z-index: 1000001;
        }


        body.custom-image-modal-open {
            overflow: hidden !important;
        }


        @media (max-width: 640px) {

            .custom-modal-overlay {
                padding: 60px 15px;
            }


            #custom-modal-image {
                max-width: 96vw;
                max-height: 82vh;
            }


            #custom-modal-close {
                top: 12px;
                right: 12px;

                width: 42px;
                height: 42px;

                font-size: 30px;
            }


            .custom-modal-nav {
                width: 40px;
                height: 40px;

                font-size: 22px;
            }


            .custom-modal-prev {
                left: 10px;
            }


            .custom-modal-next {
                right: 10px;
            }


            #custom-modal-caption {
                bottom: 12px;

                max-width: 75vw;

                font-size: 12px;
            }

        }

    `;


    document.head.appendChild(modalStyle);

});


// ==========================================
// SCROLL REVEAL ANIMATION
// ==========================================

document.addEventListener('DOMContentLoaded', () => {

    const prefersReducedMotion =
        window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;


    if (!prefersReducedMotion) {

        const revealElements =
            document.querySelectorAll('.reveal');


        const revealOptions = {
            threshold: 0.15,
            rootMargin: "0px 0px -50px 0px"
        };


        const revealObserver =
            new IntersectionObserver(
                (entries, observer) => {

                    entries.forEach(entry => {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                'active'
                            );

                            observer.unobserve(
                                entry.target
                            );

                        }

                    });

                },
                revealOptions
            );


        revealElements.forEach(el => {

            revealObserver.observe(el);

        });

    } else {

        document
            .querySelectorAll('.reveal')
            .forEach(el => {

                el.classList.add('active');

            });

    }


    // ==========================================
    // PAGE TRANSITION SYSTEM
    // ==========================================

    const transitionWrap =
        document.querySelector(
            '.page-transition-wrap'
        );


    if (transitionWrap) {

        setTimeout(() => {

            transitionWrap.classList.add(
                'page-loaded'
            );

        }, 50);


        document
            .querySelectorAll('a')
            .forEach(link => {

                link.addEventListener(
                    'click',
                    function (e) {

                        const target =
                            this.getAttribute(
                                'target'
                            );


                        const href =
                            this.getAttribute(
                                'href'
                            );


                        if (
                            !href ||
                            target === '_blank' ||
                            e.ctrlKey ||
                            e.metaKey ||
                            href.startsWith('#') ||
                            href.startsWith('mailto:') ||
                            href.startsWith('tel:') ||
                            isImageLink(href)
                        ) {
                            return;
                        }


                        try {

                            const url =
                                new URL(
                                    href,
                                    window.location.origin
                                );


                            if (
                                url.origin !==
                                window.location.origin
                            ) {
                                return;
                            }

                        } catch (err) {

                            return;

                        }


                        e.preventDefault();


                        const destination =
                            this.href;


                        transitionWrap.classList.remove(
                            'page-loaded'
                        );


                        transitionWrap.classList.add(
                            'page-leaving'
                        );


                        setTimeout(() => {

                            window.location.href =
                                destination;

                        }, 300);

                    }
                );

            });

    }

});


// ==========================================
// IMAGE LINK CHECK FOR PAGE TRANSITION
// ==========================================

function isImageLink(href) {

    if (!href) {
        return false;
    }


    const cleanUrl =
        href.split('?')[0].toLowerCase();


    return (
        cleanUrl.includes('/gallery/') ||
        cleanUrl.endsWith('.jpg') ||
        cleanUrl.endsWith('.jpeg') ||
        cleanUrl.endsWith('.png') ||
        cleanUrl.endsWith('.webp') ||
        cleanUrl.endsWith('.gif') ||
        cleanUrl.endsWith('.avif')
    );

}