class Search {
    // 1. Describe and create/initiate our object.
    constructor() {
        // this.name = "Jane";
        // this.eyeColor = "green"; // these are madeup property names
        this.openBtn = document.querySelectorAll('.js-search-trigger');
        this.closeBtn = document.querySelector('.search-overlay__close');
        this.searchOverlay = document.querySelector('.search-overlay');
        this.body = document.querySelector('body');
        this.searchInput = document.querySelector('#search-term');
        this.resultsContainer = document.querySelector('.search-overlay__results');
        this.textInputs = document.querySelectorAll('input', 'textarea');
        this.active = document.activeElement;
        this.document = document;
        this.displayOverlay = false;
        this.displaySpinner = false;
        this.previousValue;
        this.events();
    }

    // 2. Events
    events() {
        this.openBtn.forEach(item => item.addEventListener('click', this.openOverlay.bind(this)));
        this.closeBtn.addEventListener('click', this.closeOverlay.bind(this));
        this.document.addEventListener('keydown', this.keyPressDispatcher.bind(this));
        this.searchInput.addEventListener('focus', this.watchInput.bind(this));
    }

    // 3. Methods (function, actions...)
    watchInput() {
        this.searchInput.addEventListener('keyup', this.typingLogic.bind(this));
    }

    typingLogic() {
        if (this.searchInput.value != this.previousValue) {
            clearTimeout(this.typingTimer);
            if (this.searchInput.value) {
                if (!this.displaySpinner) {
                    this.resultsContainer.innerHTML = '<div class="spinner-loader"></div>';
                    this.displaySpinner = true;
                }
            this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
            } else {
                this.resultsContainer.innerHTML = '';
                this.displaySpinner = false;
            }  
        }
        this.previousValue = this.searchInput.value;
    }

    getResults() {
        
    }

    openOverlay() {
        this.searchOverlay.classList.add('search-overlay--active');
        this.body.classList.add('body-no-scroll');
    }

    closeOverlay() {
        this.searchOverlay.classList.remove('search-overlay--active');
        this.body.classList.remove('body-no-scroll');
    }

    checkInputActive() {
        var x = 0;
        this.textInputs.forEach(input => function() {
            if (input == this.active) {
                x =+ 1;
            }
        })
        return x;
    }

    keyPressDispatcher(e) {
        if(e.key == "s" && !this.displayOverlay && !this.checkInputActive() || e.key == "S" && !this.displayOverlay && !this.checkInputActive()) {
            this.openOverlay();
            this.displayOverlay = true;
        } if (e.key == "Escape" && this.displayOverlay) {
            this.closeOverlay();
            this.displayOverlay = false;
        }
    }


}

export default Search
