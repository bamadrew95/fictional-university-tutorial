import $, { getJSON, when } from 'jquery';

class Search {
    // 1. Describe and create/initate object
    constructor() {
        this.addSearchHTML();
        this.openBtn = $(".js-search-trigger");
        this.closeBtn = $(".search-overlay__close")
        this.searchOverlay = $(".search-overlay");
        this.searchInput = $("#search-term");
        this.searchResults = $(".search-overlay__results");
        this.body = $("body");
        this.inputNotSearch = $("input, textarea");
        this.document = $(document);
        this.displaySearch = false;
        this.displaySpinner = false;
        this.previousSearch;
        this.typingTimer;
        this.events();
    }

    // 2. Events functions
    events() {
        this.openBtn.on('click', this.openOverlay.bind(this));
        this.closeBtn.on('click', this.closeOverlay.bind(this));
        this.document.on('keydown', this.keyDispatch.bind(this));
        this.searchInput.on('keyup', this.typingLogic.bind(this));
    }

    // 3. Methods
    typingLogic() {
        if (this.previousSearch != this.searchInput.val()) {
            clearTimeout(this.typingTimer);
            if (this.searchInput.val()) {
                if (!this.displaySpinner) {
                    this.searchResults.html('<div class="spinner-loader"></div>')
                    this.displaySpinner = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            } else {
                this.searchResults.html('');
                this.displaySpinner = false;
            }         
        }
        this.previousSearch = this.searchInput.val();
    }

    getResults() {
        $.when(
            getJSON(universityData.root_url + '/wp-json/wp/v2/posts?search=' + this.searchInput.val()),
            getJSON(universityData.root_url + '/wp-json/wp/v2/pages?search=' + this.searchInput.val())
        ).then((posts, pages) => {
            var combinedResults = posts[0].concat(pages[0]);
            this.searchResults.html(`
            <h2 class="search-overlay__section-title">General Information</h2>
            ${combinedResults.length ? '<ul class="link-list min-list">' : '<p>No general information matches your search.</p>' }
                ${combinedResults.map(item => `<li><a href="${item.link}">${item.title.rendered}</a></li>`).join('')}
            ${combinedResults.length ? '</ul>' : ''}
            `)
        this.displaySpinner = false;
        }, () => {
            this.searchResults.html('<p>Unexpected error, please try again.</p>')
        });
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        this.body.addClass("body-no-scroll");
        this.searchInput.val('');
        setTimeout(() => this.searchInput.focus(), 301);
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        this.body.removeClass("body-no-scroll");
    }

    keyDispatch(e) {
        if (e.keyCode == 83 && this.displaySearch == false && !this.inputNotSearch.is(':focus')) {
            this.openOverlay();
            this.displaySearch = true;
            console.log(e.keyCode);          
        } if (e.keyCode == 27 && this.displaySearch == true) {
            this.closeOverlay();
            this.displaySearch = false;  
        }
    }

    addSearchHTML() {
        $("body").append(`
        <div class="search-overlay">
        <div class="search-overlay_top">
          <div class="container">
            <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
            <input type="text" class="search-term" placeholder="What are you looking for?" autocomplete="off" id="search-term">
            <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
          </div>      
        </div>
        <div class="container">
          <div class="search-overlay__results"></div>
        </div>
      </div>
      `)
    }

}

export default Search;