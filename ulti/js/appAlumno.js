//Menu toggle
let toggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let main = document.querySelector('.main');

toggle.onclick = function(){
    navigation.classList.toggle('active')
    main.classList.toggle('active')
}

//Lista de iconos
let list = document.querySelectorAll('.navigation li');
function activeLink(){
    list.forEach((item)=>
    item.classList.remove('hovered'))
    this.classList.add('hovered')
}
list.forEach((item)=>
item.addEventListener('click',activeLink))

//Acordeon Libreta
const bloque = document.querySelectorAll('.bloque')
const h2 = document.querySelectorAll('.h2')

h2.forEach((cadaH2 , i )=>{
    h2[i].addEventListener('click' , ()=>{

        bloque.forEach((cadaBloque, i)=>{
            bloque[i].classList.remove('active')
        })
        bloque[i].classList.add('active')

    })
})
