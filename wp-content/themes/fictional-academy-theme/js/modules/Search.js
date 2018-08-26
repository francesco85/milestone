import $ from 'jquery';
class Search {
    
    //area 1- descrizione e creazione/iniziazializzazione oggett0
    constructor(){
        //qualunque cosa qui dentro verrà eseguita non appena creiamo un'istanza di questo oggetto
        this.addSearchHtml();
        this.openButton = $('.js-search-trigger');
        this.closeButton = $('.search-overlay__close'); 
        this.searchOverlay = $('.search-overlay'); 
        this.searchField = $('#search-term');
        this.resultsDiv = $('#search-overlay__results');
        this.events();
        this.isOverlayOpen = false;
        this.typingTimer;
        this.isSpinnerVisible= false;
        this.previousVal;
    } 
    
    //area 2 - eventi
    events(){
        this.openButton.on('click',this.openOverlay.bind(this));
        this.closeButton.on('click',this.closeOverlay.bind(this));
        $(document).on('keydown',this.keypressDispatcher.bind(this));
        this.searchField.on('keyup', this.typingLogic.bind(this));
    }
     
    //area 3 - metodi
       
    typingLogic(){
        if(this.searchField.val() !== this.previousVal){
            clearTimeout(this.typingTimer);
            if(this.searchField.val()){
                if(!this.isSpinnerVisible){
                    this.resultsDiv.html('<div class="spinner-loader"></div>');   
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this),750);   
            }else{
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
        }
        this.previousVal = this.searchField.val();
    }
    
    getResults(){
        //uniData vedi wp_localize_script in  functions.php
        
     $.getJSON(univData.root_url+'/wp-json/university/v1/search?term=' + this.searchField.val(), (results)=>{
         this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">General information</h2>
                        ${results.generalInfo.length ? `<ul class="link-list min-list">` : `<p>No general info matches</p>`}
                        ${results.generalInfo.map(item =>`<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.author}` : '' }</li>`).join('')}
                        ${results.generalInfo.length ? `</ul>` : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Programs</h2>
                        ${results.programs.length ? `<ul class="link-list min-list">` : `<p>No Programs match. <a href="${univData.root_url}/programs">View all programs</a></p>`}
                        ${results.programs.map(item =>`<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.author}` : '' }</li>`).join('')}
                        ${results.programs.length ? `</ul>` : ''}
                        

                        <h2 class="search-overlay__section-title">Professors</h2>

                        ${results.professors.length ? `<ul class="professor-cards">` : `<p>No professor match.</p>`}
                        ${results.professors.map(item =>`
                            <li class="professor-card__list-item">
                                <a class="professor-card" href="${item.permalink}">
                                <img class="professor-card__image" src="${item.photo}" alt="">
                                <span class="professor-card__name">${item.title}</span>
                                </a>
                            </li>
                        `).join('')}
                        ${results.professors.length ? `</ul>` : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Campuses</h2>

                        ${results.campuses.length ? `<ul class="link-list min-list">` : `<p>No Programs match. <a href="${univData.root_url}/campuses">View all campuses</a></p>`}
                        ${results.campuses.map(item =>`<li><a href="${item.permalink}">${item.title}</a>${item.postType == 'post' ? ` by ${item.author}` : '' }</li>`).join('')}
                        ${results.campuses.length ? `</ul>` : ''}


                        <h2 class="search-overlay__section-title">Events</h2>

                        ${results.events.length ? `<ul class="link-list min-list">` : `<p>No Events match. <a href="${univData.root_url}/events">View all events</a></p>`}
                        ${results.events.map(item =>`
                            <div class="event-summary">
                                <a class="event-summary__date t-center" href="${item.permalink}">
                                <span class="event-summary__month">${item.month}</span>
                                <span class="event-summary__day">${item.day}</span>  
                                </a>
                                <div class="event-summary__content">
                                    <h5 class="event-summary__title headline headline--tiny"><a href="${item.permalink}">${item.title}</a></h5>
                                    <p>
                                    ${item.description} 
                                    <a href="${item.permalink}" class="nu gray">Learn more</a></p>
                                </div>
</div>
                        `).join('')}
                        ${results.events.length ? `</ul>` : ''}
                    </div>
                </div> 
        `);
         this.isSpinnerVisible = false;
     });
        
        
    /*
        
        //utilizziamo la sintassi di es6 con arrow function () => {} oppure parametro => {}
        //questa permette di legare direttamete la keyword this all'oggetto principale evitando confusione con lo scope ed evitando di dover fare bind all'oggetto principale
        //inoltre per non dover scrivere html tutto in una linea si può inserirlo tra ` html ` evitando che javascript rilevi errori, altrimenti per separare linee \ ma sbatta! 
        
        //usiamo metodi when(dove ficchiamo tutte le richieste asincrone e dove andranno le getJSON) e then(i risultati di ogni richiesta asincrona di when verranno mappati rispettivamente verso i parametri di then)
        $.when(
            //solitamente getJSON prende due parametri ma qui non necessaria la callback function perchè i risultati verranno direttamente passati a then
            $.getJSON(univData.root_url+'/wp-json/wp/v2/posts?search='+this.searchField.val()),
            $.getJSON(univData.root_url+'/wp-json/wp/v2/pages?search='+this.searchField.val())
        ).then((posts,pages) => {
                //i parametri di then contengono anche info relative alla richiesta json(es se fallita o no) e quindi avremo il nostro array con i risultati della richiesta json nel primo elemento..quindi [0]
                var combinedRes = posts[0].concat(pages[0]); 
                this.resultsDiv.html(`<h2 class="search-overlay__section-title">General Information</h2>
                
                    ${combinedRes.length ? `<ul class="link-list min-list">` : `<p>No general info matches</p>`}
                    ${combinedRes.map(item =>`<li><a href="${item.link}">${item.title.rendered}</a>${item.type == 'post' ? ` by ${item.authorName}` : '' }</li>`).join('')}
                    ${combinedRes.length ? `</ul>` : ''}`
                                );
                this.isSpinnerVisible = false;
        }, () => {
            //secondo parametro di then è handle per errori
            this.resultsDiv.html('<p>Unexpected error, try again');
        });
        
    */
    }
    
    openOverlay(){
        this.searchOverlay.addClass('search-overlay--active');
        $('body').addClass('body-no-scroll');
        this.searchField.val('');
        setTimeout(()=>{
            this.searchField.focus();
        },300);
        this.isOverlayOpen = true;
        return false; //previene il comportamento di default di a!
    }
    
    closeOverlay(){
        this.searchOverlay.removeClass('search-overlay--active');
        $('body').removeClass('body-no-scroll');
        this.isOverlayOpen = false;
    }
    
    keypressDispatcher(e){
        //s -> se tasto s e non overlay aperto e non input o textarea in focus
        if(e.keyCode == 83 && !this.isOverlayOpen && !$('input,textarea').is(':focus')){
        console.log(e.keyCode);
           this.openOverlay();
//            alert('opened');
        }
        //esc
        if(e.keyCode == 27 && this.isOverlayOpen){
            this.closeOverlay();
        } 
    }
    
    addSearchHtml(){
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top"></div>
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" id="search-term" class="search-term" placeholder="Cosa cerchi?" autofocus>
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
            </div>
        `);
    }
    
}


export default Search;