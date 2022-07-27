<script>
window.addEventListener('load', function(){
    document.querySelectorAll('.like-btn').forEach(item=>{ // seleciona todos os botões e faz um loop em cada elemento
        item.addEventListener('click', ()=>{ // o loop permite que cada item (botão) tenha uma função de click
            let id = item.closest('.feed-item').getAttribute('data-id'); // pega o antecessor(feed-item) de item e seu atributo(data-id) 
            let count = parseInt(item.innerText); // pega o elemento interno de item e transforma em inteiro(número)
            if(item.classList.contains('on') === false) { // verifica se o elemento da classe do item é false
                item.classList.add('on'); // adiciona a classe on 
                item.innerText = ++count; // adiciona +1 ao elemento interno 
            } else {
                item.classList.remove('on'); // retira a classe on
                item.innerText = --count; // diminui -1 ao elemento interno
            }
            fetch('ajax_like.php?id='+id); // arquivo que fará o processo no banco de dados, pois o javascript está alterando visualmente. Ou seja, após recarregar a página volta como estava
        });
    });
    
    function closeFeedWindow() {
        document.querySelectorAll('.feed-item-more-window').forEach(item=>{
            item.style.display = 'none';
        });
        
        document.removeEventListener('click', closeFeedWindow);
    }

    document.querySelectorAll('.feed-item-head-btn').forEach(item=>{
        item.addEventListener('click', ()=>{
            closeFeedWindow();

            item.querySelector('.feed-item-more-window').style.display = 'block';
            setTimeout(()=>{
                document.addEventListener('click', closeFeedWindow);
            }, 500);
        });
    });

document.querySelectorAll('.fic-item-field').forEach(item=>{
        item.addEventListener('keyup', async (e)=>{
            if(e.keyCode == 13) {
                let id = item.closest('.feed-item').getAttribute('data-id');
                let txt = item.value;
                item.value = '';

                let data = new FormData();
                data.append('id', id);
                data.append('txt', txt);

                let req = await fetch('ajax_comment.php', {
                    method: 'POST',
                    body: data
                });
                let json = await req.json();

                if(json.error == '') {
                    let html = '<div class="fic-item row m-height-10 m-width-20">';
                    html += '<div class="fic-item-photo">';
                    html += '<a href="'+json.link+'"><img src="'+json.avatar+'" /></a>';
                    html += '</div>';
                    html += '<div class="fic-item-info">';
                    html += '<a href="'+json.link+'">'+json.name+'</a>';
                    html += json.body;
                    html += '</div>';
                    html += '</div>';

                    item.closest('.feed-item')
                        .querySelector('.feed-item-comments-area')
                        .innerHTML += html;
                }

            }
        });
    });
});
</script>