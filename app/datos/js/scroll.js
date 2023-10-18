let block = false;
let page = 0;

window.onload = async function(){
    this.loadItems();
};

window.addEventListener("scroll", async function(event) {
    const scrollHeight = this.scrollY;
    const viewportHeight = document.documentElement.clientHeight;
    const moreScroll = document.getElementById('more-tuits').offsetTop;
    const currentScroll = scrollHeight + viewportHeight;
    
    
    if((currentScroll >= moreScroll) && block === false){
        block = true;

       this.setTimeout(() =>{
            loadItems();
            block = false;
       }, 2000);
    }
});

async function loadItems(){
    const data = await requestData(page);
    const response = data[0];
        
    if(response.response === '200'){
        const items = data[1];
        page = data[2].page;
    
        renderItems(items);
    }
}

function requestData(n){
    const url = './config/api.php?action=more&page=' + n;
    console.log(url);
    const response = this.fetch(url)
    .then(res => res.json())
    .then(data => data);

    return response;
}

function renderItems(data){
    let tuits = document.querySelector('#tuits');
    data.forEach(element => {
            tuits.innerHTML += `
            <div class="caja">
            <div class="imagen">
                <img src="./../../ps-contenido/img/maestros/${element.img}" alt="">
            </div>
            <div class="contenido">
                <h3>${element.titulo}</h3>
                <p>${element.vista}</p>
            </div>
            <div class="boton">
                <a href="post?titulo=${element.titulo}">Conocer más</a>
            </div>
        </div>
            `;
    });
    
}