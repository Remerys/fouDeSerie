new TomSelect("#serie_genres",{
    plugins: ['remove_button'],
    render:{
        option:function(data,escape){
            return '<div class="d-flex"><span>' + escape(data.value) + '</span><span class="ms-auto text-muted">' + '&nbsp' + escape(data.text) + '</span></div>';
        },
        item:function(data,escape){
            return '<div>' + escape(data.text) + '</div>';
        }
    }
});
