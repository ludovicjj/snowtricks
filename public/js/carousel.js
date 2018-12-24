class Carousel {

    /**
     * This callback type is called 'requestCallback' and is displayed as a global symbol.
     *
     * @callback moveCallback
     * @param {number} index
     */

    /**
     * @param {HTMLElement} element
     * @param {Object} options
     * @param {Object} [options.slidesToScroll=1] nombre d'éléments a faire défiler
     * @param {Object} [options.slideVisible=1] nombre d'éléments visible dans un slide
     * @param {boolean} [options.loop=false] Doit on boucler en fin de slide
     */
    constructor(element, options = {}) {
        this.element = element;
        this.options = Object.assign({}, {
            slidesToScroll : 1,
            slidesVisible: 1,
            loop: false
        }, options);
        let children = [].slice.call(element.children);
        this.isMobile = false;
        this.currentItem = 0;
        this.moveCallbacks = [];

        // Modification du DOM
        this.root = this.createDivWithClass('carousel');
        this.mycontainer = this.createDivWithClass('carousel__container');
        this.container = this.createDivWithClass('carousel__panorama');
        this.mycontainer.appendChild(this.container);
        this.root.appendChild(this.mycontainer);
        this.element.appendChild(this.root);
        this.items = children.map((child) =>{
            let item = this.createDivWithClass('carousel__item');
            item.appendChild(child);
            this.container.appendChild(item);
            return item;
        });
        this.setStyle();
        this.createNavigation();


        // Evenement
        this.moveCallbacks.forEach(cd =>cd(0));
        this.onWindowResize();
        window.addEventListener('resize', this.onWindowResize.bind(this));
    }

    /**
     * Applique les bonnes dimensions aux éléments du carousel
     */
    setStyle () {
        let ratio = this.items.length / this.slidesVisible;
        this.container.style.width = (ratio * 100) + "%";
        this.items.forEach(item =>  item.style.width = ((100 / this.slidesVisible) / ratio) + "%");
    }

    createNavigation () {
        let nextButton = this.createDivWithClass('carousel__next');
        let prevButton = this.createDivWithClass('carousel__prev');
        this.root.appendChild(nextButton);
        this.root.appendChild(prevButton);
        nextButton.addEventListener('click', this.next.bind(this));
        prevButton.addEventListener('click', this.prev.bind(this));
        if (this.options.loop === true) {
            return;
        }
        this.onMove(index => {
            if (index === 0) {
                prevButton.classList.add('carousel__prev--hidden');
            } else {
                prevButton.classList.remove('carousel__prev--hidden');
            }
            if (this.items[this.currentItem + this.slidesVisible] === undefined) {
                nextButton.classList.add('carousel__next--hidden');
            } else {
                nextButton.classList.remove('carousel__next--hidden');
            }
        })
    }

    next () {
        this.gotoItem(this.currentItem + this.slidesToScroll);
    }

    prev () {
        this.gotoItem(this.currentItem - this.slidesToScroll);
    }

    /**
     * Déplace le carousel vers l'élément ciblé
     * @param {number} index
     */
    gotoItem (index) {
        if (index < 0) {
            index = this.items.length - this.slidesVisible;
        } else if (index >= this.items.length || (this.items[this.currentItem + this.slidesVisible] === undefined && index >
            this.currentItem)) {
            index = 0;
        }
        let translateX = index * -100 / this.items.length;
        this.container.style.transform = 'translate3d(' + translateX + '%, 0, 0)';
        this.currentItem = index;
        this.moveCallbacks.forEach(cd =>cd(index));
    }

    /**
     * @param {moveCallback} cb
     */
    onMove (cb) {
        this.moveCallbacks.push(cb);
    }

    onWindowResize () {
        let mobile = window.innerWidth < 800;
        if (mobile !== this.isMobile) {
            this.isMobile = mobile;
            this.setStyle();
            this.moveCallbacks.forEach(cd =>cd(this.currentItem));
        }
    }

    /**
     * @param {string} classname
     * @returns {HTMLElement}
     */
    createDivWithClass(classname) {
        let div = document.createElement('div');
        div.setAttribute('class', classname);
        return div
    }

    /**
     * @returns {number}
     */
    get slidesToScroll () {
        return this.isMobile ? 1 : this.options.slidesToScroll;
    }

    /**
     * @returns {number}
     */
    get slidesVisible () {
        return this.isMobile ? 1 : this.options.slidesVisible;
    }

}

document.addEventListener('DOMContentLoaded', function() {
    new Carousel(document.querySelector('#carousel_image'), {
        slidesToScroll : 1,
        slidesVisible: 3,
        loop: false
    });

    new Carousel(document.querySelector('#carousel_video'), {
        slidesToScroll : 1,
        slidesVisible: 1,
        loop: false
    });
});

