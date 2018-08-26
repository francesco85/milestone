import $ from 'jquery';



class Like{
    constructor(){
        this.events();
    }
    
    events(){
        $('.like-box').on('click', this.ourClickDispatcher.bind(this));
    }
    
    
    //methods
    
    ourClickDispatcher(e){
        //closest is looking for ancestor element
        var likeBox = $(e.target).closest('.like-box');
        if(likeBox.attr('data-exists') == 'yes'){
            this.deleteLike(likeBox);   
        }else{
            this.createLike(likeBox);
        }
    }
    
    createLike(likeBox){
        
        $.ajax({
            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',univData.nonce);
            },
            url: univData.root_url + '/wp-json/university/v1/likeManage', 
            type: 'POST',
            data:{'professorId':likeBox.data('professor')},
            success: (response) => {
                likeBox.attr('data-exists','yes');
                var likeCount = parseInt(likeBox.find('.like-count').html(),10);
                likeCount++;
                likeBox.find('.like-count').html(likeCount);
                likeBox.attr('data-like',response);
                console.log(response);
            },
            error: (error) => {console.log(error);}
        });
    }
    deleteLike(likeBox){
        $.ajax({
            beforeSend: (xhr)=>{
                xhr.setRequestHeader('X-WP-Nonce',univData.nonce);
            },
            url: univData.root_url + '/wp-json/university/v1/likeManage',
            type: 'DELETE',
            data:{'like': likeBox.attr('data-like')},
            success: (response) => {
                likeBox.attr('data-exists','no');
                var likeCount = parseInt(likeBox.find('.like-count').html(),10);
                likeCount--;
                likeBox.find('.like-count').html(likeCount);
                likeBox.attr('data-like','');
                console.log(response);
            },
            error: (error) => {console.log(error);}
        });
        
    }
}

export default Like;