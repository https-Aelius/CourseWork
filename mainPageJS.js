let next = document.getElementById('next');
let prev = document.getElementById('prev');
let carousel = document.querySelector('.carousel');
let items = document.querySelectorAll('.carousel .item');
let countItem = items.length;
let active=1;
let other_1 = null;
let other_2 = null;
next.onclick=()=>{
    carousel.classList.remove('prev');
    carousel.classList.add('next');
    //adding and removing the classes 'next' and 'prev' to the carousel

    active = active+1 >= countItem ? 0 : active+1;
    // when user clicks on the next button, we increase the items position by 1 to activate the next item
    // when the set position is greater than the total number of items, we reset the active position to 0
    // this creates an endless loop
    other_1 = active-1 < 0 ? countItem-1 : active-1;
    // the position of item 'other_1' will be 1 unit less than the active position
    // it is minus one because it is set on the left side of the active item
    other_2 = active+1 >= countItem ? 0 : active+1;
    changeSlider();
    //after setting enough values for these variables we run a change slider function to change the slider
}
prev.onclick=()=>{
    carousel.classList.remove('next');
    carousel.classList.add('prev');
    active = active -1 < 0 ? countItem-1 : active-1;
    other_1 = active + 1>=countItem?0:active+1;
    other_2 = other_1+1>=countItem?0:other_1+1;
    changeSlider();
}

const changeSlider = () =>{
    let itemOldActive = document.querySelector('.carousel .item.active');
    // finding the item that was previously activated 
    if(itemOldActive) itemOldActive.classList.remove('active');
    // if it exists, we remove the active class to remove its active state
    
    let itemOldOther_1 = document.querySelector('.carousel .item.other_1');
    if(itemOldOther_1) itemOldOther_1.classList.remove('other_1');
    //same thing will happen for items marked as other_1 and other_2
    //because when clicking next the values of these positions change
    let itemOldOther_2 = document.querySelector('.carousel .item.other_2');
    if(itemOldOther_2) itemOldOther_2.classList.remove('other_2');

    items.forEach(e=>{
        // e.querySelector('.image img').computedStyleMap.animation = 'none';
        // e.querySelector('.image figcaption').computedStyleMap.animation = 'none';
        e.querySelector('.image img').style.animation = 'none';
        e.querySelector('.image figcaption').style.animation = 'none';
        //for each item, the elements that ran the animation effect will be sent to null
        void e.offsetWidth;
        e.querySelector('.image img').style.animation = '';
        e.querySelector('.image figcaption').style.animation = '';
    })    
    //refreshing the animations by calling out the entire list of items



    items[active].classList.add('active');
    //once completed we proceed to add the active class to the new active item
    items[other_1].classList.add('other_1');
    items[other_2].classList.add('other_2');
    //same thing happens for other_1 and other_2
}

