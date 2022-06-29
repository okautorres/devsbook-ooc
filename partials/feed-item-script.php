<script>
window.onload = function() { // espera todo o documento (página) ser carregada
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
};
</script>