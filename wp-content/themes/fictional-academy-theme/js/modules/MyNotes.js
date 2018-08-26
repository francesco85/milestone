import $ from 'jquery';
class MyNotes{
    //costruttore
    constructor(){
        this.events();
        
    }
    //eventi
    events(){
        //per note create successivamente alla pagina caricata non verranno ascoltati gli eventi..unico modo e fare questa modifica: stare in attesa dell'evento click dell'elemento genitore e se click su classe indicata allora parte funzione
        $('#my-notes').on('click', '.delete-note',this.deleteNote);
        $('#my-notes').on('click', '.edit-note',this.editNote.bind(this));
        $('#my-notes').on('click', '.update-note',this.updateNote.bind(this));
        $('.submit-note').on('click',this.createNote.bind(this));
    }
    
    
    //metodi
        
    deleteNote(e){
//        var thisNote= $(e.target).parents('li').attr('data-id'); oopure...
        var thisNote= $(e.target).parents('li');
        //per procedere con cancellazione dati in wp dobbiamo icludere un una sequenza segreta di dati durante la richiesta ajax.. Nonce(number once) è un numero generato automaticamente da wp al login, una sorta di token
        $.ajax({
            beforeSend: (xhr)=>{
                //così possiamo passare dati extra alla request..settiamo header della request inserendo il Nonce; wp cercherà esattamente il primo argomento inserito qui sotto e verificherà che sia lo stesso dell'utente loggato
                xhr.setRequestHeader('X-WP-Nonce',univData.nonce);
            },
//            url: univData.root_url + '/wp-json/wp/v2/note/' + thisNote, oppure...
            url: univData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'DELETE',
            success: (response)=>{
                thisNote.slideUp();//cosi le eliminiamo on the fly dalla pagina!
                console.log('congr');
                console.log(response);
                
                if(response.userNoteCount < 3){
                    $('.note-limit-message').removeClass('active');
                }
            },
            error: (error)=>{
                console.log('sorry');
                console.log(error);
            }
        }); 
    }
    
    
    editNote(e){
        var thisNote= $(e.target).parents('li');
        if(thisNote.data('state') == 'editable'){
           //make readOnly
            this.makeNoteReadonly(thisNote);
        }else{
           this.makeNoteEditable(thisNote);
        }
        
    }
    
    makeNoteEditable(thisNote){
        thisNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel');
        thisNote.find('.note-title-field , .note-body-field').removeAttr('readonly')
        .addClass('note-active-field');
        thisNote.find('.update-note').addClass('update-note--visible');
        thisNote.data('state', 'editable');
    }
    
    makeNoteReadonly(thisNote){
        thisNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit');
        thisNote.find('.note-title-field , .note-body-field').attr('readonly','readonly')
        .removeClass('note-active-field');
        thisNote.find('.update-note').removeClass('update-note--visible');
        thisNote.data('state','cancel');
    }
    
    updateNote(e){
        var thisNote= $(e.target).parents('li');
        var updatedPost = {
            'title': thisNote.find('.note-title-field').val(),
            'content': thisNote.find('.note-body-field').val()
        };
        $.ajax({
            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',univData.nonce);
            },
            url: univData.root_url + '/wp-json/wp/v2/note/' + thisNote.data('id'),
            type: 'POST',
            data: updatedPost,
            success: (response)=>{
                this.makeNoteReadonly(thisNote);
                console.log('congr');
                console.log(response);
            },
            error: (error)=>{
                console.log('sorry');
                console.log(error);
            }
        }); 
    }
    
    
    createNote(){
        var createPost = {
            'title': $('.new-note-title').val(),
            'content': $('.new-note-body').val(),
            'status' : 'publish'
        };
        $.ajax({
            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',univData.nonce);
            },
            url: univData.root_url + '/wp-json/wp/v2/note/',
            type: 'POST',
            data: createPost,
            success: (response)=>{
                $('.new-note-title, .new-note-body').val('');
                $(`<li data-id="${response.id}">
                   <!--per sicurezza ogni volta che usiamo info dal db usiamo esc_attr()-->
                    <input readonly class="note-title-field" type="text" value="${response.title.raw}">
                    <span class="edit-note"> <i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"> <i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field">
                        ${response.content.raw}
                    </textarea>
                    <span class="update-note btn btn--blue btn--small"> <i class="fa fa-arrow" aria-hidden="true"></i> Save</span>
                </li>`).prependTo('#my-notes').hide().slideDown();
                console.log('congr');
                console.log(response);
            },
            error: (error)=>{
                if(error.responseText == "You've write too many posts, sorry"){
                    $('.note-limit-message').addClass('active');   
                }
                console.log('sorry');
                console.log(error);
            }
        });
    }
}


export default MyNotes;