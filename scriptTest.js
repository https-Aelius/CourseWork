function activateProductSlider(){

    const product_slider = document.querySelectorAll('.productDimensionSlider'); //selects all the product sliders
    product_slider.forEach(product_slider=>{
        const navigation_links = product_slider.querySelectorAll('.dimensionSliderNav');  //navigation links for dimensions
        const image_slide = product_slider.querySelectorAll('.productDimensionSliderImages');  
        console.log(image_slide);
        navigation_links.forEach((navigation_link, i)=>{
            navigation_link.onclick = () =>{
                console.log(`Navigation link ${i} clicked`);
                activateSlider(navigation_links, i); 
                activateSlider(image_slide, i);


            }
        });
        init();
        function init(){
            activateSlider(navigation_links, 0); 
            activateSlider(image_slide, 0); 

        }
        function activateSlider(arr, i) {
            arr.forEach((arr_item, arr_index) => {

                if (arr_index === i) {
                    console.log('activating', arr_item, i);
                    arr_item.classList.add('active');
                }
                else {
                    arr_item.classList.remove('active');
                }
            });
        }

    });
}
window.addEventListener('load', activateProductSlider);