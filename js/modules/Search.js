class Search {
    // 1. Describe and create/initiate our object.
    constructor() {
        // this.name = "Jane";
        // this.eyeColor = "green"; // these are madeup property names
        this.openBtn = document.querySelectorAll('.js-search-trigger');
        this.closeBtn = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.body = document.querySelector('body');
        this.document = document;
        this.displayOverlay = false;
        this.events();
    }

    // 2. Events
    events() {
        this.openBtn.forEach(item => item.addEventListener('click', this.openOverlay));
        this.closeBtn.addEventListener('click', this.closeOverlay);
        this.document.addEventListener('keydown', this.keyPressDispatcher);
    }

    // 3. Methods (function, actions...)
    openOverlay() {
        search.searchOverlay.classList.add('search-overlay--active');
        search.body.classList.add('body-no-scroll');
    }

    closeOverlay() {
        search.searchOverlay.classList.remove('search-overlay--active');
        search.body.classList.remove('body-no-scroll');
    }

    keyPressDispatcher(e) {
        if(e.key == "s" && !obj.displayOverlay || e.key == "S" && !obj.displayOverlay) {
            search.openOverlay();
            search.displayOverlay = true;
        } if (e.key == "Escape" && obj.displayOverlay) {
            search.closeOverlay();
            search.displayOverlay = false;
        }
    }
}

export default Search
